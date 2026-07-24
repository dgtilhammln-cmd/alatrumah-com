<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ResiController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        return view('home.cek-resi', compact('settings'));
    }
    public function track(Request $request)
    {
        $request->validate(
            ['awb'=>'required|string|max:100','courier'=>'required|string|max:50'],
            ['awb.required'=>'Nomor resi wajib diisi.','courier.required'=>'Kurir wajib dipilih.']
        );
        $settings = Setting::getAllAsArray();
        $awb      = trim($request->awb);
        $courier  = strtolower(trim($request->courier));
        $apiKey   = $settings['rajaongkir_api_key'] ?? null;

        if (empty($apiKey)) {
            return view('home.cek-resi', [
                'settings' => $settings,
                'awb'      => $awb,
                'courier'  => $courier,
                'error'    => 'API key RajaOngkir belum dikonfigurasi. Hubungi administrator.',
            ]);
        }

        try {
            // Komerce new endpoint: POST /api/v1/track/waybill with param 'awb' (not 'waybill')
            $response = Http::withoutVerifying()
                ->timeout(20)
                ->withHeaders([
                    'key'          => $apiKey,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->asForm()
                ->post('https://rajaongkir.komerce.id/api/v1/track/waybill', [
                    'awb'     => $awb,
                    'courier' => $courier,
                ]);

            $json = $response->json();
            $meta = $json['meta'] ?? [];
            $data = $json['data'] ?? null;

            // Check for API errors
            if (!$data || ($meta['code'] ?? 200) != 200) {
                $msg = $meta['message'] ?? 'Resi tidak ditemukan atau kurir tidak mendukung pelacakan.';
                Log::warning('[RESI] API error', ['meta' => $meta, 'awb' => $awb, 'courier' => $courier]);
                return view('home.cek-resi', compact('settings','awb','courier') + ['error' => $msg]);
            }

            $summary    = $data['summary']         ?? [];
            $details    = $data['details']          ?? [];
            $manifest   = $data['manifest']         ?? [];
            $delivery   = $data['delivery_status']  ?? [];

            // Normalize status
            $st    = strtolower($delivery['status'] ?? $summary['status'] ?? '');
            $label = match(true) {
                str_contains($st, 'delivered')   => 'TERKIRIM',
                str_contains($st, 'transit')      => 'DALAM PERJALANAN',
                str_contains($st, 'pickup')       => 'PICKUP',
                str_contains($st, 'on process')   => 'DIPROSES',
                str_contains($st, 'return')        => 'DIKEMBALIKAN',
                str_contains($st, 'out for')       => 'DALAM PENGIRIMAN',
                default                            => strtoupper($delivery['status'] ?? $summary['status'] ?? 'TIDAK DIKETAHUI'),
            };

            $tracking = [
                'summary' => [
                    'awb'     => $awb,
                    'courier' => strtoupper($summary['courier_name'] ?? $courier),
                    'service' => $summary['service_code'] ?? '-',
                    'status'  => $label,
                ],
                'detail'  => [
                    'shipper'     => $details['shipper_name']   ?? ($summary['shipper_name']   ?? '-'),
                    'origin'      => $details['origin']         ?? ($summary['origin']          ?? '-'),
                    'receiver'    => $details['receiver_name']  ?? ($summary['receiver_name']   ?? '-'),
                    'destination' => $details['destination']    ?? ($summary['destination']     ?? '-'),
                    'weight'      => isset($details['weight']) ? $details['weight'] . ' gr' : '-',
                ],
                'history' => array_map(function ($m) {
                    return [
                        'date'     => ($m['manifest_date'] ?? '') . ' ' . ($m['manifest_time'] ?? ''),
                        'desc'     => $m['manifest_description'] ?? ($m['title'] ?? '-'),
                        'location' => $m['city_name'] ?? '',
                    ];
                }, $manifest),
            ];

            Log::info('[RESI] Tracking sukses', ['awb' => $awb, 'courier' => $courier, 'status' => $label]);
            return view('home.cek-resi', compact('settings','tracking','awb','courier'));

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('[RESI] Connection error: ' . $e->getMessage());
            return view('home.cek-resi', compact('settings', 'awb', 'courier') + [
                'error' => 'Gagal terhubung ke server ekspedisi. Pastikan koneksi internet aktif dan coba lagi.',
            ]);
        } catch (\Throwable $e) {
            Log::error('[RESI] Error: ' . $e->getMessage());
            return view('home.cek-resi', compact('settings','awb','courier') + ['error' => 'Terjadi kesalahan. Coba lagi nanti.']);
        }
    }
}
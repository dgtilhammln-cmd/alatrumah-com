<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ResiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('awb') && $request->filled('courier')) {
            return $this->track($request);
        }
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
        // Map common codes to RajaOngkir codes
        $courierMap = [
            'idx' => 'ide',
            'ninja' => 'ninjaxpress'
        ];
        $mappedCourier = $courierMap[$courier] ?? $courier;
        
        $apiKey   = $settings['shipping_delivery_api_key'] ?: ($settings['rajaongkir_api_key'] ?? null);
        $apiType  = $settings['rajaongkir_type'] ?? 'starter';

        if (empty($apiKey)) {
            return view('home.cek-resi', [
                'settings' => $settings,
                'awb'      => $awb,
                'courier'  => $courier,
                'error'    => 'API key RajaOngkir/Delivery belum dikonfigurasi. Hubungi administrator.',
            ]);
        }
        
        if ($apiType === 'starter') {
            return view('home.cek-resi', [
                'settings' => $settings,
                'awb'      => $awb,
                'courier'  => $courier,
                'error'    => 'Akun Starter RajaOngkir tidak mendukung fitur pelacakan resi. Upgrade ke Basic/Pro.',
            ]);
        }

        try {
            $baseUrl = match($apiType) {
                'pro', 'enterprise'   => 'https://pro.rajaongkir.com/api',
                default => 'https://api.rajaongkir.com/basic' // Starter blocked above, Basic is fallback
            };

            $url = $baseUrl . '/waybill';

            $response = Http::withoutVerifying()
                ->timeout(20)
                ->withHeaders([
                    'key'          => $apiKey,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->asForm()
                ->post($url, [
                    'waybill' => $awb,
                    'courier' => $mappedCourier
                ]);

            $json = $response->json();
            Log::info('[RESI] Raw API response', ['status' => $response->status(), 'body' => $json, 'awb' => $awb, 'courier' => $mappedCourier]);

            $ro = $json['rajaongkir'] ?? [];
            $status = $ro['status'] ?? [];
            $result = $ro['result'] ?? null;

            // Check for API errors
            if (!$result || ($status['code'] ?? 200) != 200) {
                $msg = $status['description'] ?? 'Resi tidak ditemukan atau kurir tidak mendukung pelacakan.';
                Log::warning('[RESI] API error', ['status' => $status, 'awb' => $awb, 'courier' => $courier]);
                return view('home.cek-resi', compact('settings','awb','courier') + ['error' => $msg]);
            }

            $summary    = $result['summary']         ?? [];
            $details    = $result['details']          ?? [];
            $manifest   = $result['manifest']         ?? [];
            $delivery   = $result['delivery_status']  ?? [];

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
                    $rawDesc = trim($m['manifest_description'] ?? '');
                    $title   = trim($m['title'] ?? '');

                    // Map generic/short manifest codes to readable Indonesian labels
                    $titleMap = [
                        'Pickup'          => 'Paket Diambil oleh Kurir',
                        'Delivered'       => 'Paket Diterima di Titik Pengumpulan',
                        'Transit Center'  => 'Paket di Transit Center',
                        'On Delivery'     => 'Paket Dalam Pengiriman ke Penerima',
                        'Received'        => 'Paket Diterima oleh Penerima',
                        'Return'          => 'Paket Dikembalikan',
                    ];

                    // If description is too generic (1-10 chars or just "Manifes"), use title mapping
                    $isGeneric = strlen($rawDesc) <= 10 ||
                                 in_array(strtolower($rawDesc), ['manifes', 'manifest', 'pickup', 'transit', '-', '']);

                    if ($isGeneric && $title) {
                        $desc = $titleMap[$title] ?? ($title . (strlen($rawDesc) > 2 && !$isGeneric ? " - {$rawDesc}" : ''));
                    } else {
                        $desc = $rawDesc ?: ($titleMap[$title] ?? $title ?: '-');
                    }

                    return [
                        'date'     => ($m['manifest_date'] ?? '') . ' ' . ($m['manifest_time'] ?? ''),
                        'desc'     => $desc,
                        'location' => $m['city_name'] ?? '',
                        'title'    => $title,
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
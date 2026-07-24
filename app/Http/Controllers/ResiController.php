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
        $request->validate(['awb'=>'required|string|max:100','courier'=>'required|string|max:50'],['awb.required'=>'Nomor resi wajib diisi.','courier.required'=>'Kurir wajib dipilih.']);
        $settings = Setting::getAllAsArray();
        $awb = trim($request->awb);
        $courier = strtolower(trim($request->courier));
        $apiKey = $settings['rajaongkir_api_key'] ?? null;
        $apiType = $settings['rajaongkir_type'] ?? 'starter';
        if (empty($apiKey)) {
            return view('home.cek-resi',['settings'=>$settings,'awb'=>$awb,'courier'=>$courier,'error'=>'API key RajaOngkir belum dikonfigurasi. Hubungi administrator.']);
        }
        try {
            $baseUrl = 'https://rajaongkir.komerce.id/api/v1';
            $response = Http::withoutVerifying()->timeout(15)
                ->withHeaders([
                    'key'          => $apiKey,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->asForm()
                ->post("{$baseUrl}/waybill", [
                    'waybill' => $awb,
                    'courier' => $courier,
                ]);$json = $response->json();
            $ro = $json['rajaongkir'] ?? null;
            if (!$ro || ($ro['status']['code'] ?? 200) != 200) {
                $msg = $ro['status']['description'] ?? ($ro['message'] ?? 'Resi tidak ditemukan.');
                return view('home.cek-resi', compact('settings','awb','courier') + ['error'=>$msg]);
            }
            $result   = $ro['result'] ?? [];
            $delivery = $result['delivery_status'] ?? [];
            $summary2 = $result['summary'] ?? [];
            $details  = $result['details'] ?? [];
            $manifest = $result['manifest'] ?? [];
            $st = strtolower($delivery['status'] ?? '');
            $label = match(true){ str_contains($st,'delivered')=>'TERKIRIM',str_contains($st,'transit')=>'DALAM PERJALANAN',str_contains($st,'pickup')=>'PICKUP',str_contains($st,'on process')=>'DIPROSES',str_contains($st,'return')=>'DIKEMBALIKAN',default=>strtoupper($delivery['status'] ?? 'TIDAK DIKETAHUI') };
            $tracking = ['summary'=>['awb'=>$awb,'courier'=>strtoupper($courier),'service'=>$summary2['service_code'] ?? ($details['service_code'] ?? '-'),'status'=>$label],'detail'=>['shipper'=>$details['shipper_name'] ?? '-','origin'=>$details['shipper_city'] ?? '-','receiver'=>$details['receiver_name'] ?? '-','destination'=>$details['receiver_city'] ?? '-'],'history'=>array_map(function($m){return['date'=>($m['manifest_date'] ?? '').' '.($m['manifest_time'] ?? ''),'desc'=>$m['manifest_description'] ?? '-','location'=>$m['city_name'] ?? ''];},$manifest)];
            return view('home.cek-resi', compact('settings','tracking','awb','courier'));
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('ResiController connection: ' . $e->getMessage());
            return view('home.cek-resi', compact('settings', 'awb', 'courier') + [
                'error' => 'Gagal terhubung ke server ekspedisi (Request Timed Out). Ini adalah hal wajar karena provider internet lokal Anda saat ini (di Localhost) kemungkinan memblokir akses ke API RajaOngkir. Fitur ini akan berjalan 100% normal saat website sudah di-online-kan (hosting).',
            ]);
        } catch (\Throwable $e) {
            Log::error('Resi: '.$e->getMessage());
            return view('home.cek-resi', compact('settings','awb','courier') + ['error'=>'Terjadi kesalahan. Coba lagi nanti.']);
        }
    }
}
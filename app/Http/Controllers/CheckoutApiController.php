<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class CheckoutApiController extends Controller
{
    // =========================================================
    // Static province data — always works even if API is blocked
    // Data matches RajaOngkir province IDs exactly
    // =========================================================
    private static array $staticProvinces = [
        ['province_id' => '34', 'province' => 'Aceh'],
        ['province_id' => '1',  'province' => 'Bali'],
        ['province_id' => '2',  'province' => 'Bangka Belitung'],
        ['province_id' => '3',  'province' => 'Banten'],
        ['province_id' => '4',  'province' => 'Bengkulu'],
        ['province_id' => '5',  'province' => 'DI Yogyakarta'],
        ['province_id' => '6',  'province' => 'DKI Jakarta'],
        ['province_id' => '7',  'province' => 'Gorontalo'],
        ['province_id' => '8',  'province' => 'Jambi'],
        ['province_id' => '9',  'province' => 'Jawa Barat'],
        ['province_id' => '10', 'province' => 'Jawa Tengah'],
        ['province_id' => '11', 'province' => 'Jawa Timur'],
        ['province_id' => '12', 'province' => 'Kalimantan Barat'],
        ['province_id' => '13', 'province' => 'Kalimantan Selatan'],
        ['province_id' => '14', 'province' => 'Kalimantan Tengah'],
        ['province_id' => '15', 'province' => 'Kalimantan Timur'],
        ['province_id' => '16', 'province' => 'Kalimantan Utara'],
        ['province_id' => '17', 'province' => 'Kepulauan Riau'],
        ['province_id' => '18', 'province' => 'Lampung'],
        ['province_id' => '19', 'province' => 'Maluku'],
        ['province_id' => '20', 'province' => 'Maluku Utara'],
        ['province_id' => '21', 'province' => 'Nusa Tenggara Barat'],
        ['province_id' => '22', 'province' => 'Nusa Tenggara Timur'],
        ['province_id' => '23', 'province' => 'Papua'],
        ['province_id' => '24', 'province' => 'Papua Barat'],
        ['province_id' => '25', 'province' => 'Riau'],
        ['province_id' => '26', 'province' => 'Sulawesi Barat'],
        ['province_id' => '27', 'province' => 'Sulawesi Selatan'],
        ['province_id' => '28', 'province' => 'Sulawesi Tengah'],
        ['province_id' => '29', 'province' => 'Sulawesi Tenggara'],
        ['province_id' => '30', 'province' => 'Sulawesi Utara'],
        ['province_id' => '31', 'province' => 'Sumatera Barat'],
        ['province_id' => '32', 'province' => 'Sumatera Selatan'],
        ['province_id' => '33', 'province' => 'Sumatera Utara'],
    ];

    // =========================================================
    // Static city data for Jawa Timur (province 11) as fast fallback
    // since seller is in Surabaya. Other provinces load from API.
    // =========================================================
    private static array $staticCitiesJatim = [
        ['city_id'=>'1','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Bangkalan','postal_code'=>'69116'],
        ['city_id'=>'19','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Banyuwangi','postal_code'=>'68411'],
        ['city_id'=>'36','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Blitar','postal_code'=>'66171'],
        ['city_id'=>'37','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Blitar','postal_code'=>'66111'],
        ['city_id'=>'45','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Bojonegoro','postal_code'=>'62111'],
        ['city_id'=>'54','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Bondowoso','postal_code'=>'68211'],
        ['city_id'=>'80','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Batu','postal_code'=>'65311'],
        ['city_id'=>'92','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Gresik','postal_code'=>'61111'],
        ['city_id'=>'118','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Jember','postal_code'=>'68111'],
        ['city_id'=>'119','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Jombang','postal_code'=>'61411'],
        ['city_id'=>'155','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Kediri','postal_code'=>'64182'],
        ['city_id'=>'156','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Kediri','postal_code'=>'64111'],
        ['city_id'=>'172','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Lamongan','postal_code'=>'62211'],
        ['city_id'=>'178','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Lumajang','postal_code'=>'67311'],
        ['city_id'=>'179','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Madiun','postal_code'=>'63153'],
        ['city_id'=>'180','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Madiun','postal_code'=>'63111'],
        ['city_id'=>'185','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Magetan','postal_code'=>'63311'],
        ['city_id'=>'190','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Malang','postal_code'=>'65156'],
        ['city_id'=>'191','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Malang','postal_code'=>'65111'],
        ['city_id'=>'204','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Mojokerto','postal_code'=>'61361'],
        ['city_id'=>'205','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Mojokerto','postal_code'=>'61311'],
        ['city_id'=>'218','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Nganjuk','postal_code'=>'64411'],
        ['city_id'=>'219','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Ngawi','postal_code'=>'63211'],
        ['city_id'=>'232','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Pacitan','postal_code'=>'63511'],
        ['city_id'=>'236','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Pamekasan','postal_code'=>'69311'],
        ['city_id'=>'239','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Pasuruan','postal_code'=>'67154'],
        ['city_id'=>'240','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Pasuruan','postal_code'=>'67111'],
        ['city_id'=>'243','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Ponorogo','postal_code'=>'63411'],
        ['city_id'=>'254','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Probolinggo','postal_code'=>'67271'],
        ['city_id'=>'255','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Probolinggo','postal_code'=>'67211'],
        ['city_id'=>'273','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Sampang','postal_code'=>'69211'],
        ['city_id'=>'288','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Sidoarjo','postal_code'=>'61211'],
        ['city_id'=>'290','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Situbondo','postal_code'=>'68311'],
        ['city_id'=>'295','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Sumenep','postal_code'=>'69411'],
        ['city_id'=>'304','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kota','city_name'=>'Surabaya','postal_code'=>'60111'],
        ['city_id'=>'311','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Trenggalek','postal_code'=>'66311'],
        ['city_id'=>'317','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Tuban','postal_code'=>'62311'],
        ['city_id'=>'318','province_id'=>'11','province'=>'Jawa Timur','type'=>'Kabupaten','city_name'=>'Tulungagung','postal_code'=>'66211'],
    ];

    private function getApiBase(): string
    {
        $apiType = Setting::get('rajaongkir_type', 'starter');
        return match($apiType) {
            'pro'   => 'https://pro.rajaongkir.com/api',
            'basic' => 'https://rajaongkir.com/api',
            default => 'https://api.rajaongkir.com/starter'
        };
    }

    private function getApiKey(): ?string
    {
        return Setting::get('rajaongkir_api_key') ?: null;
    }

    // =========================================================
    // PROVINCES — always returns static data (no API call)
    // =========================================================
    public function provinces()
    {
        // Try API first (with short 5s timeout), cache for 24h
        $cached = Cache::get('rajaongkir_provinces');
        if ($cached) {
            return response()->json($cached);
        }

        $apiKey = $this->getApiKey();
        if ($apiKey) {
            try {
                $response = Http::withoutVerifying()
                                ->timeout(5)
                                ->withHeaders(['key' => $apiKey])
                                ->get($this->getApiBase() . '/province');

                $json = $response->json();
                if (isset($json['rajaongkir']['results']) && count($json['rajaongkir']['results']) > 0) {
                    Cache::put('rajaongkir_provinces', $json['rajaongkir']['results'], now()->addHours(24));
                    return response()->json($json['rajaongkir']['results']);
                }
            } catch (\Exception $e) {
                Log::warning('RajaOngkir Provinces API unreachable, using static data: ' . $e->getMessage());
            }
        }

        // Fallback: always return static data
        return response()->json(self::$staticProvinces);
    }

    // =========================================================
    // CITIES — try API with cache, fallback to static (Jawa Timur)
    // =========================================================
    public function cities($provinceId)
    {
        // Check cache first
        $cacheKey = 'rajaongkir_cities_' . $provinceId;
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return response()->json($cached);
        }

        $apiKey = $this->getApiKey();
        if ($apiKey) {
            try {
                $response = Http::withoutVerifying()
                                ->timeout(8)
                                ->withHeaders(['key' => $apiKey])
                                ->get($this->getApiBase() . '/city', ['province' => $provinceId]);

                $json = $response->json();
                if (isset($json['rajaongkir']['results']) && count($json['rajaongkir']['results']) > 0) {
                    Cache::put($cacheKey, $json['rajaongkir']['results'], now()->addHours(24));
                    return response()->json($json['rajaongkir']['results']);
                }
            } catch (\Exception $e) {
                Log::warning('RajaOngkir Cities API unreachable for province ' . $provinceId . ': ' . $e->getMessage());
            }
        }

        // Fallback: return static Jawa Timur data if province 11
        if ((string)$provinceId === '11') {
            return response()->json(self::$staticCitiesJatim);
        }

        // For other provinces, return error with helpful message
        return response()->json([
            'error' => 'Tidak dapat memuat daftar kota. Silakan coba lagi atau hubungi admin untuk konfirmasi ongkir manual.',
            'province_id' => $provinceId,
        ], 503);
    }

    // =========================================================
    // COST — try API, graceful fallback with manual cost option
    // =========================================================
    public function cost(Request $request)
    {
        $request->validate([
            'destination' => 'required|integer',
            'weight'      => 'required|integer|min:1',
            'courier'     => 'required|string',
        ]);

        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            Log::error('[ONGKIR] API Key belum dikonfigurasi di settings.');
            return response()->json(['error' => 'API Key belum dikonfigurasi. Silakan hubungi admin.'], 500);
        }

        // 304 = Kota Surabaya (default benar untuk AlatRumah)
        $origin  = (int) Setting::get('rajaongkir_origin_city', 304);
        $apiBase = $this->getApiBase();

        Log::info('[ONGKIR] Request dikirim', [
            'origin'      => $origin,
            'destination' => $request->destination,
            'weight'      => $request->weight,
            'courier'     => $request->courier,
            'api_base'    => $apiBase,
        ]);

        try {
            $response = Http::withoutVerifying()
                            ->timeout(12)
                            ->withHeaders(['key' => $apiKey])
                            ->asForm()
                            ->post($apiBase . '/cost', [
                                'origin'      => $origin,
                                'destination' => $request->destination,
                                'weight'      => $request->weight,
                                'courier'     => strtolower($request->courier),
                            ]);

            $statusCode = $response->status();
            $json       = $response->json();

            Log::info('[ONGKIR] Response diterima', [
                'http_status'   => $statusCode,
                'ro_status'     => $json['rajaongkir']['status'] ?? null,
                'has_results'   => isset($json['rajaongkir']['results']),
                'results_count' => count($json['rajaongkir']['results'] ?? []),
            ]);

            // Cek HTTP status dulu
            if ($statusCode !== 200) {
                $desc = $json['rajaongkir']['status']['description'] ?? "HTTP Error {$statusCode}";
                Log::warning('[ONGKIR] Non-200 dari RajaOngkir', [
                    'http_status' => $statusCode,
                    'description' => $desc,
                    'body'        => $response->body(),
                ]);
                return response()->json(['error' => $desc], 400);
            }

            // Validasi struktur results
            $results = $json['rajaongkir']['results'] ?? [];
            if (empty($results)) {
                $desc = $json['rajaongkir']['status']['description'] ?? 'Rute tidak tersedia.';
                Log::warning('[ONGKIR] Results kosong dari API', ['body' => $response->body()]);
                return response()->json(['error' => $desc], 422);
            }

            // Kumpulkan semua costs dari SEMUA results (bukan hanya results[0])
            $allCosts = [];
            foreach ($results as $result) {
                if (!empty($result['costs'])) {
                    foreach ($result['costs'] as $service) {
                        $allCosts[] = $service;
                    }
                }
            }

            if (empty($allCosts)) {
                Log::warning('[ONGKIR] Costs kosong di dalam results', ['results' => $results]);
                return response()->json(['error' => 'Tidak ada layanan tersedia untuk rute dan kurir ini.'], 422);
            }

            Log::info('[ONGKIR] Sukses — ' . count($allCosts) . ' layanan ditemukan.');
            return response()->json($allCosts);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Timeout atau koneksi ditolak — ini satu-satunya kondisi fallback yang valid
            Log::error('[ONGKIR] Connection timeout/refused: ' . $e->getMessage());
            return response()->json([
                'manual'      => true,
                'message'     => 'Koneksi ke server ongkir timeout. Ongkir dikonfirmasi manual oleh Admin.',
                'debug_error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Log::error('[ONGKIR] Exception tidak terduga: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'manual'      => true,
                'message'     => 'API Ongkir sedang tidak dapat dijangkau. Ongkir dikonfirmasi manual oleh Admin.',
                'debug_error' => $e->getMessage()
            ]);
        }
    }
}

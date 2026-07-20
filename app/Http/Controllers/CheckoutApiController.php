<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class CheckoutApiController extends Controller
{
    private function getApiBase()
    {
        $apiType = Setting::get('rajaongkir_type', 'starter');
        return match($apiType) {
            'pro'   => 'https://pro.rajaongkir.com/api',
            'basic' => 'https://rajaongkir.com/api',
            default => 'https://api.rajaongkir.com/starter'
        };
    }

    private function getApiKey()
    {
        return Setting::get('rajaongkir_api_key');
    }

    public function provinces()
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) return response()->json(['error' => 'API Key not configured'], 500);

        try {
            $response = Http::withoutVerifying()->withHeaders(['key' => $apiKey])
                            ->get($this->getApiBase() . '/province');
            
            $json = $response->json();
            if (isset($json['rajaongkir']['results'])) {
                return response()->json($json['rajaongkir']['results']);
            }
            return response()->json(['error' => 'Invalid response from RajaOngkir'], 500);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Provinces Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to API'], 500);
        }
    }

    public function cities($provinceId)
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) return response()->json(['error' => 'API Key not configured'], 500);

        try {
            $response = Http::withoutVerifying()->withHeaders(['key' => $apiKey])
                            ->get($this->getApiBase() . '/city', ['province' => $provinceId]);
            
            $json = $response->json();
            if (isset($json['rajaongkir']['results'])) {
                return response()->json($json['rajaongkir']['results']);
            }
            return response()->json(['error' => 'Invalid response from RajaOngkir'], 500);
        } catch (\Exception $e) {
            Log::error('RajaOngkir Cities Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to API'], 500);
        }
    }

    public function cost(Request $request)
    {
        $request->validate([
            'destination' => 'required|integer',
            'weight'      => 'required|integer|min:1',
            'courier'     => 'required|string',
        ]);

        $apiKey = $this->getApiKey();
        if (!$apiKey) return response()->json(['error' => 'API Key not configured'], 500);

        // User requested Origin City to be Surabaya (ID 444)
        $origin = Setting::get('rajaongkir_origin_city', 444);

        try {
            $response = Http::withoutVerifying()->withHeaders(['key' => $apiKey])
                            ->asForm()
                            ->post($this->getApiBase() . '/cost', [
                                'origin'      => $origin,
                                'destination' => $request->destination,
                                'weight'      => $request->weight,
                                'courier'     => strtolower($request->courier),
                            ]);
            
            $json = $response->json();
            if (isset($json['rajaongkir']['results'][0]['costs'])) {
                return response()->json($json['rajaongkir']['results'][0]['costs']);
            }
            
            // If costs array is missing or empty, maybe courier is not supported or route is invalid
            $msg = $json['rajaongkir']['status']['description'] ?? 'Error fetching cost';
            return response()->json(['error' => $msg], 400);

        } catch (\Exception $e) {
            Log::error('RajaOngkir Cost Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to connect to API'], 500);
        }
    }
}

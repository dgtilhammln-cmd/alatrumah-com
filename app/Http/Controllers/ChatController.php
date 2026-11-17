<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'name'    => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:50',
        ]);

        $name = auth()->check() ? auth()->user()->name : $request->name;
        $phone = auth()->check() ? (auth()->user()->addresses->first()->phone ?? '') : $request->phone;
        $email = auth()->check() ? auth()->user()->email : null;

        // Fallback names for guests
        if (!$name) $name = 'Guest';

        Lead::create([
            'name'    => $name,
            'phone'   => $phone,
            'email'   => $email,
            'message' => $request->message,
            'source'  => 'Chat Widget',
            'status'  => 'new',
            'page_url' => url()->previous(),
        ]);

        // Redirect to WA Admin (ambil nomor primary dari database, fallback ke nomor baru)
        $wa = \App\Models\WaSetting::primary();
        $adminWa = $wa ? ($wa->nomor_wa ?: '6285735180390') : '6285735180390';
        $waNumber = preg_replace('/[^0-9]/', '', $adminWa);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
        
        $text = "Halo CS, saya {$name} ingin bertanya:\n\n{$request->message}";
        
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($text);

        return redirect()->away($waUrl);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)
            ->whereIn('role', ['admin', 'super_admin'])
            ->where('is_active', true)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'admin_logged_in'   => true,
                'admin_id'          => $user->id,
                'admin_name'        => $user->name,
                'admin_email'       => $user->email,
                'admin_role'        => $user->role,
                'admin_permissions' => $user->admin_permissions ?? [],
            ]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()->withInput()->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role', 'admin_permissions']);
        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }
}

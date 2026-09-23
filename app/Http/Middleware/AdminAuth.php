<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $adminId = session('admin_id');
        $user = \App\Models\User::find($adminId);

        if (!$user || !$user->is_active || !in_array($user->role, ['admin', 'super_admin'])) {
            session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role', 'admin_permissions']);
            return redirect('/admin/login')->with('error', 'Akun Anda tidak aktif atau tidak ditemukan.');
        }

        session([
            'admin_name'        => $user->name,
            'admin_email'       => $user->email,
            'admin_role'        => $user->isSuperAdmin() ? 'super_admin' : $user->role,
            'admin_permissions' => $user->admin_permissions,
        ]);

        return $next($request);
    }
}

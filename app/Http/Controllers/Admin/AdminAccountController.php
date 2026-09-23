<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
{
    public static function availablePermissions(): array
    {
        return [
            'dashboard'      => 'Dashboard (Main)',
            'products'       => 'Produk & Layanan',
            'articles'       => 'Artikel',
            'clients'        => 'Klien',
            'testimonials'   => 'Testimoni',
            'leads'          => 'Laporan Chat',
            'hero_slides'    => 'Banner Hero',
            'gallery'        => 'Galeri',
            'analytics'      => 'Analytics',
            'authors'        => 'Penulis',
            'coupons'        => 'Kupon / Voucher',
            'couriers'       => 'Pengiriman / Kurir',
            'orders'         => 'Pesanan',
            'users'          => 'Pengguna (Buyer)',
            'usp'            => 'USP Bar',
            'category_items' => 'Kategori',
            'promo_sections' => 'Promo & Deals',
            'settings'       => 'Pengaturan System & WA',
            'apikeys'        => 'API & Integrasi',
        ];
    }

    private function checkSuperAdmin()
    {
        $currentAdmin = User::find(session('admin_id'));
        if (!$currentAdmin || !$currentAdmin->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengelola akun admin.');
        }
        return $currentAdmin;
    }

    public function index()
    {
        $this->checkSuperAdmin();

        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->latest()
            ->get();

        return view('admin.accounts.index', compact('admins'));
    }

    public function create()
    {
        $this->checkSuperAdmin();
        $permissions = self::availablePermissions();
        return view('admin.accounts.form', [
            'admin'       => new User(),
            'permissions' => $permissions,
            'isEdit'      => false,
        ]);
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:6|confirmed',
            'role'                => 'required|in:admin,super_admin',
            'admin_permissions'   => 'nullable|array',
            'admin_permissions.*' => 'string',
            'is_active'           => 'boolean',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => $validated['role'],
            'admin_permissions' => $validated['role'] === 'super_admin' ? array_keys(self::availablePermissions()) : ($validated['admin_permissions'] ?? []),
            'is_active'         => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $account)
    {
        $this->checkSuperAdmin();
        if (!in_array($account->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        $permissions = self::availablePermissions();
        return view('admin.accounts.form', [
            'admin'       => $account,
            'permissions' => $permissions,
            'isEdit'      => true,
        ]);
    }

    public function update(Request $request, User $account)
    {
        $this->checkSuperAdmin();
        if (!in_array($account->role, ['admin', 'super_admin'])) {
            abort(404);
        }

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($account->id)],
            'password'            => 'nullable|string|min:6|confirmed',
            'role'                => 'required|in:admin,super_admin',
            'admin_permissions'   => 'nullable|array',
            'admin_permissions.*' => 'string',
            'is_active'           => 'boolean',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'role'              => $validated['role'],
            'admin_permissions' => $validated['role'] === 'super_admin' ? array_keys(self::availablePermissions()) : ($validated['admin_permissions'] ?? []),
            'is_active'         => $request->has('is_active') ? (bool) $request->is_active : false,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $account->update($updateData);

        return redirect()->route('admin.accounts.index')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(User $account)
    {
        $this->checkSuperAdmin();
        if ($account->id === session('admin_id')) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($account->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus Super Admin terakhir.');
        }

        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Akun admin berhasil dihapus.');
    }

    // Profil Mandiri Admin (Ganti username/email & password sendiri)
    public function profile()
    {
        $user = User::findOrFail(session('admin_id'));
        return view('admin.accounts.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(session('admin_id'));

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => 'nullable|string',
            'password'         => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!empty($request->password)) {
            if (empty($request->current_password) || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        session([
            'admin_name'  => $user->name,
            'admin_email' => $user->email,
        ]);

        return back()->with('success', 'Profil dan kredensial login berhasil diperbarui.');
    }
}

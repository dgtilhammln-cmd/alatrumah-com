<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'username', 'phone', 'avatar', 'google_id', 'role', 'is_active', 'admin_permissions'];
    protected $hidden = ['password', 'remember_token'];
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function isOnline()
    {
        return \Illuminate\Support\Facades\Cache::has('user-is-online-' . $this->id);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            'admin_permissions'   => 'array',
        ];
    }

    /**
     * Apakah user ini super admin (akses penuh).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin' || ($this->role === 'admin' && is_null($this->admin_permissions));
    }

    /**
     * Cek apakah admin memiliki permission tertentu.
     * Super admin atau admin baru (permissions null) selalu punya akses.
     */
    public function hasPermission(string $key): bool
    {
        if ($this->isSuperAdmin() || is_null($this->admin_permissions)) {
            return true;
        }
        $perms = $this->admin_permissions ?? [];
        return in_array($key, $perms);
    }

    // =========================================================================
    // Relationships (E-commerce)
    // =========================================================================

    /**
     * Semua alamat pengiriman milik user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Alamat pengiriman utama (default).
     */
    public function defaultAddress(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    /**
     * Semua order milik user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Semua item cart milik user.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Semua wishlist milik user.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Semua pemakaian kupon oleh user.
     */
    public function couponUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
}

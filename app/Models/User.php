<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function canAccessFilament(): bool
    {
        return $this->role === 'admin';
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}

// Hitung total pembayaran student
public function totalPayments()
{
    return $this->payments()->paid()->sum('amount');
}
public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
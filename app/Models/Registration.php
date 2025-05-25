<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'program_id',
        'parent_name',
        'parent_email',
        'parent_phone',
        'student_name',
        'student_age',
        'student_gender',
        'student_photo',
        'medical_notes',
        'status',
        'payment_proof',
        'payment_status',
        'registration_date'
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    /**
     * Relasi ke User (orang tua)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Class
     */
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    /**
     * Relasi ke Program
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Relasi ke Payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Hitung total yang sudah dibayar
     */
    public function totalPaid()
    {
        return $this->payments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    /**
     * Cek status pembayaran
     */
    public function getPaymentStatusAttribute()
    {
        $totalPaid = $this->totalPaid();
        $totalDue = $this->class->price;

        if ($totalPaid >= $totalDue) {
            return 'Lunas';
        } elseif ($totalPaid > 0) {
            return 'Cicilan';
        } else {
            return 'Belum Bayar';
        }
    }

    /**
     * Scope untuk registrasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'approved');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'user_id',
        'amount',
        'method',
        'transaction_id',
        'proof',
        'status',
        'paid_at',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function income()
    {
        return $this->hasOne(Income::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }
    
    // public function payable()
    // {
    //     return $this->morphTo();
    // }
}
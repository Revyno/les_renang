<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'tax',
        'operational_fee',
        'instructor_fee',
        'net_income',
        'income_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax' => 'decimal:2',
        'operational_fee' => 'decimal:2',
        'instructor_fee' => 'decimal:2',
        'net_income' => 'decimal:2',
        'income_date' => 'date'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($income) {
            $income->calculateNetIncome();
        });
    }

    public function calculateNetIncome()
    {
        $this->net_income = $this->amount - $this->tax - $this->operational_fee - $this->instructor_fee;
        return $this;
    }
}
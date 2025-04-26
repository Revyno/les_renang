<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'max_participants',
        'schedule',
        'level',
        'status',
        'image'
    ];

    /**
     * Get all registrations for this program
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get instructors assigned to this program
     */
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'program_instructor');
    }

    /**
     * Get active programs
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Format price as currency
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

  
}
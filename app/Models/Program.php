<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age_range',
        'day',
        'schedule_date',
        'schadule_end',
        'start_time',
        'end_time',
        'capacity',
        'toggle',
        'price',
        'description',
        'thumbnail',
        'class_id',
        'instructor_id',
    ];

    protected $casts = [
        'toggle' => 'boolean',
        'price' => 'decimal:0',
        'thumbnail' => 'array',
    ];

    /**
     * Get all registrations for this program
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }


    
    /**
     * Get instructor assigned to this program
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
   
    /**
     * Get active programs
     */
    public function scopeActive($query)
    {
        return $query->where('toggle', true);
    }

    /**
     * Format price as currency
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
    
    

    public function getAvailableSlotsAttribute()
    {
        return $this->capacity - $this->students()->count();
    }
}
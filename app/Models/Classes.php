<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'level',
        'description',
        'price',
        'sessions',
        'duration_weeks',
       
    ];
      public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // public function registrations()
    // {
    //     return $this->hasMany(Registration::class);
    // }



    // public function getFormattedPriceAttribute()
    // {
    //     return 'Rp ' . number_format($this->price, 0, ',', '.');
    // }
   
//   public function instructor()
//     {
//         return $this->belongsTo(Instructor::class,  'instructors_id');

//     }
// public function instructors()
// {
//     return $this->belongsToMany(Instructor::class, 'class_instructor', 'class_id', 'instructor_id');
// }
public function instructors()
{
    return $this->belongsToMany(Instructor::class,'class_instructor', 'class_id', 'instructor_id');
}


  

public function payments()
{
    return $this->hasManyThrough(
        Payment::class,
        Registration::class,
        'class_id', // FK di registrations
        'registration_id', // FK di payments
        'id', // PK di swim_levels
        'id' // PK di registrations
    );
}

// Hitung pendapatan per level
 public function totalIncome()
    {
        return $this->payments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
       public function scopeActive($query)
    {
        return $query->whereHas('registrations', function($q) {
            $q->where('status', 'approved');
        });
    }
    
}
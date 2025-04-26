<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'schedule_date', 'schedule_time', 'capacity', 'price'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}

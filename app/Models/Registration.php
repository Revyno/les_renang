<?php

// app/Models/Registration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'usia',
        'program',
        'jadwal',
        'tingkat_kemampuan',
        'status',
        
    ];
    
}

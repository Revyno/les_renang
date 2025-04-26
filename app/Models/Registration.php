<?php

// app/Models/Registration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'usia',
        'program',
        'jadwal',
        'tingkat_kemampuan',
        'status',
        'program_id', 
        'instructor_id', 
        'start_date', 
        'status', 
        'notes'
        
    ];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

}

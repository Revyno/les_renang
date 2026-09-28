<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan oleh model
    protected $table = 'enrollments';

    // Menentukan field mana yang bisa diisi (mass assignable)
    protected $fillable = [
        'registration_id',
        'class_id',
        'program_id',
        'instructor_id',
        'status',
        'payment_status',
    ];

    // Relasi dengan model Registration
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // Relasi dengan model Classes
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Relasi dengan model Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relasi dengan model Instructor
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}

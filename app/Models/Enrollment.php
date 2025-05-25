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
        // 'student_id',
        // 'classes_id',
        // 'program_id',
        // 'instructor_id',
        'status',
        'payment_status',
        'created_at',
    ];

    // Relasi dengan model Student
  

    // Relasi dengan model Classes
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
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

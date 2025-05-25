<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'nama',
        // 'email',
       
        // 'jenis_kelamin',
        // 'telepon',
        // 'alamat',
        // 'spesialisasi',
        // 'pengalaman_tahun',
        // 'image',
        'name',
        'jenis_kelamin',
        'email',
        'certification',
        'specialization',
        'pengalaman_tahun',
        'telepon',
        'bio',
        'photo',
        'twitter',
        'facebook',
        'instagram',
        'linkedin',
    ];
   

    //banyak kelas instructur bisa mengambil banyak kelas 
    public function classes()
    {
    return $this->belongsToMany(Classes::class ,'class_instructor', 'instructor_id', 'class_id');
    }

   
// satu rols hanya bisa mengambil satu kelas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    // public function classes()
    // {
    //     return $this->hasMany(Classes::class);
    // }

 

}

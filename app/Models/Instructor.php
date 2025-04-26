<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'spesialisasi',
        'pengalaman_tahun',
        'image',
    ];

    public function Instructor()
    {
        return $this->hasMany(Instructor::class);
    }
}

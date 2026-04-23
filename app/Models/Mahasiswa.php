<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'user_id',
        'nisn',
        'nama_lengkap',
        'jurusan',
        'alamat',
        'kelas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}

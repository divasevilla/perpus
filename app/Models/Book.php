<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'nama_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'stok_buku',
        'kategori',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_buku', 'id_buku');
    }
}

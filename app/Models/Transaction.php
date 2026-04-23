<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_mahasiswa',
        'id_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'denda',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku', 'id_buku');
    }

    /**
     * Hitung denda otomatis: Rp 1.000 per hari keterlambatan.
     * Batas pinjam: 7 hari.
     */
    public function hitungDenda(): int
    {
        $batasPinjam = 7;
        $tglPinjam   = Carbon::parse($this->tanggal_pinjam);
        $tglHitung   = $this->tanggal_kembali
            ? Carbon::parse($this->tanggal_kembali)
            : Carbon::today();

        $totalHari = $tglPinjam->diffInDays($tglHitung);

        if ($totalHari > $batasPinjam) {
            return ($totalHari - $batasPinjam) * 1000;
        }

        return 0;
    }
}

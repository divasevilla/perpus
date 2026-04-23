<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Mahasiswa;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_buku'      => Book::count(),
            'total_anggota'   => Mahasiswa::count(),
            'total_pinjam'    => Transaction::whereIn('status', ['menunggu', 'dipinjam'])->count(),
            'total_kembali'   => Transaction::where('status', 'selesai')->count(),
            'transaksi_terbaru' => Transaction::with(['mahasiswa', 'book'])
                                    ->latest()
                                    ->take(5)
                                    ->get(),
            'stok_habis'      => Book::where('stok_buku', 0)->count(),
        ];

        return view('admin.dashboard', $data);
    }
}

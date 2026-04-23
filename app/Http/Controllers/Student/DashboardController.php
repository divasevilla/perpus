<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $id_mahasiswa = $user->mahasiswa->id_mahasiswa ?? null;

        $data = [
            'sedang_pinjam' => Transaction::where('id_mahasiswa', $id_mahasiswa)
                                ->whereIn('status', ['menunggu', 'dipinjam'])->count(),
            'total_pinjam'  => Transaction::where('id_mahasiswa', $id_mahasiswa)->count(),
            'total_denda'   => Transaction::where('id_mahasiswa', $id_mahasiswa)->sum('denda'),
            'riwayat'       => Transaction::with('book')
                                ->where('id_mahasiswa', $id_mahasiswa)
                                ->latest()
                                ->take(5)
                                ->get(),
        ];

        return view('student.dashboard', $data);
    }
}

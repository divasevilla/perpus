<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private const MAX_PINJAM = 3;

    public function index()
    {
        $transactions = Transaction::with('book')
            ->where('id_mahasiswa', auth()->user()->mahasiswa->id_mahasiswa)
            ->latest()
            ->paginate(10);

        return view('student.transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:books,id_buku',
        ]);

        $mahasiswa = auth()->user()->mahasiswa;

        // Cek batas pinjam
        $pinjamAktif = Transaction::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($pinjamAktif >= self::MAX_PINJAM) {
            return back()->with('error', 'Batas maksimal pinjam ' . self::MAX_PINJAM . ' buku telah tercapai.');
        }

        // Cek stok buku
        $book = Book::findOrFail($request->id_buku);
        if ($book->stok_buku <= 0) {
            return back()->with('error', 'Stok buku habis, tidak bisa dipinjam.');
        }

        // Cek sudah pinjam buku yang sama
        $sudahPinjam = Transaction::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->where('id_buku', $request->id_buku)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Kamu sudah meminjam atau sedang mengajukan peminjaman untuk buku ini.');
        }

        Transaction::create([
            'id_mahasiswa'  => $mahasiswa->id_mahasiswa,
            'id_buku'       => $book->id_buku,
            'tanggal_pinjam'=> Carbon::today(),
            'status'        => 'menunggu',
            'denda'         => 0,
        ]);

        // Kurangi stok
        $book->decrement('stok_buku');

        return redirect()->route('student.transactions.index')
            ->with('success', 'Permintaan peminjaman buku berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function kembali(Transaction $transaction)
    {
        if ($transaction->id_mahasiswa !== auth()->user()->mahasiswa->id_mahasiswa) {
            abort(403);
        }

        if ($transaction->status === 'selesai') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        if ($transaction->status !== 'dipinjam') {
            return back()->with('error', 'Hanya buku yang sedang dipinjam yang dapat dikembalikan.');
        }

        $tanggalKembali = Carbon::today();
        $denda          = $transaction->hitungDenda();

        $transaction->update([
            'status'          => 'selesai',
            'tanggal_kembali' => $tanggalKembali,
            'denda'           => $denda,
        ]);

        $transaction->book->increment('stok_buku');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('student.transactions.index')->with('success', $pesan);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['mahasiswa', 'book'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"))
                  ->orWhereHas('book', fn($q) => $q->where('nama_buku', 'like', "%{$search}%"));
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['mahasiswa', 'book']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:dipinjam,ditolak,selesai',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'ditolak') {
            // Jika ditolak, kembalikan stok buku
            $transaction->book->increment('stok_buku');
        } elseif ($request->status === 'selesai') {
            $tanggalKembali = Carbon::today();
            $data['tanggal_kembali'] = $tanggalKembali;
            $data['denda'] = $transaction->hitungDenda();

            // Kembalikan stok buku
            $transaction->book->increment('stok_buku');
        } elseif ($request->status === 'dipinjam') {
            $data['tanggal_pinjam'] = Carbon::today();
        }

        $transaction->update($data);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }
}

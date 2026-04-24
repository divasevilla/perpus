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

        // OPTIONAL: kalau filter status masih dipakai
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('mahasiswa', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%{$search}%");
                })->orWhereHas('book', function ($q2) use ($search) {
                    $q2->where('nama_buku', 'like', "%{$search}%");
                });
            });
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
            'status' => 'required|in:menunggu,dipinjam,ditolak,selesai',
        ]);

        $data = ['status' => $request->status];

        switch ($request->status) {

            case 'menunggu':
                // reset semua (opsional)
                $data['tanggal_pinjam'] = null;
                $data['tanggal_kembali'] = null;
                $data['denda'] = 0;
                break;

            case 'dipinjam':
                $data['tanggal_pinjam'] = Carbon::today();
                break;

            case 'ditolak':
                // kembalikan stok
                $transaction->book->increment('stok_buku');
                break;

            case 'selesai':
                $tanggalKembali = Carbon::today();
                $data['tanggal_kembali'] = $tanggalKembali;
                $data['denda'] = $transaction->hitungDenda();

                // kembalikan stok
                $transaction->book->increment('stok_buku');
                break;
        }

        $transaction->update($data);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }
}
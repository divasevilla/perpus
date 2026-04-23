<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['mahasiswa', 'book'])->latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->get();

        return view('admin.reports.index', compact('transactions'));
    }

    public function print(Request $request)
    {
        $query = Transaction::with(['mahasiswa', 'book'])->latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->get();

        return view('admin.reports.print', compact('transactions'));
    }
}
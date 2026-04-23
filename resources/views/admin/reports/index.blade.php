@extends('layouts.app')
@section('title', 'Laporan Peminjaman')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Laporan')
@section('page-title', 'Laporan Peminjaman')
@include('admin._sidebar')

@section('content')
<div class="card" style="margin-bottom:24px;">
    <div class="card-header"><span class="card-title">Filter Laporan</span></div>
    <form method="GET" action="{{ route('admin.reports.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div>
            <label style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:4px;">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div>
            <label style="font-size:0.8rem;color:var(--text-muted);display:block;margin-bottom:4px;">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div style="display:flex;gap:8px;">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" class="btn btn-success">🖨️ Cetak</a>
            @if(request()->hasAny(['start_date','end_date']))
                <a href="{{ route('admin.reports.index') }}" class="btn btn-ghost">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->mahasiswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $t->book->nama_buku ?? '-' }}</td>
                    <td>{{ $t->tanggal_pinjam?->format('d M Y') }}</td>
                    <td>{{ $t->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                    <td><span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    <td>{{ $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px;">Tidak ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Transaksi')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Transaksi')
@section('page-title', 'Manajemen Transaksi')
@include('admin._sidebar')

@section('content')
<!-- Filter -->
<form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
    <input type="text" name="search" class="form-control" style="max-width:240px;" placeholder="Cari nama/buku..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-ghost">Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td>{{ $transactions->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $t->mahasiswa->nama_lengkap ?? '-' }}</div>
                        <div style="font-size:0.7rem;color:var(--text-muted);">{{ $t->mahasiswa->nisn ?? '' }}</div>
                    </td>
                    <td>{{ $t->book->nama_buku ?? '-' }}</td>
                    <td>{{ $t->tanggal_pinjam?->format('d M Y') }}</td>
                    <td>{{ $t->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                    <td>
                        @if($t->denda > 0)
                            <span style="color:var(--danger);font-weight:600;">Rp {{ number_format($t->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.transactions.show', $t->id_transaksi) }}" class="btn btn-ghost btn-sm">Detail</a>
                            @if($t->status === 'menunggu')
                            <form action="{{ route('admin.transactions.update', $t->id_transaksi) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dipinjam">
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form action="{{ route('admin.transactions.update', $t->id_transaksi) }}" method="POST" onsubmit="return confirm('Tolak peminjaman ini?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                            @elseif($t->status === 'dipinjam')
                            <form action="{{ route('admin.transactions.update', $t->id_transaksi) }}" method="POST" onsubmit="return confirm('Tandai sebagai sudah dikembalikan?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--text-muted);padding:32px;">Tidak ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
        <div style="margin-top:16px;">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection

@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Transaksi / Detail')
@section('page-title', 'Detail Transaksi')
@include('admin._sidebar')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:900px;">
    <div class="card">
        <div class="card-header"><span class="card-title">👤 Info Anggota</span></div>
        <table style="font-size:.85rem;">
            <tr><td style="color:var(--text-muted);padding:6px 0;width:130px;">Nama</td><td><strong>{{ $transaction->mahasiswa->nama_lengkap ?? '-' }}</strong></td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">NISN</td><td>{{ $transaction->mahasiswa->nisn ?? '-' }}</td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">Jurusan</td><td>{{ $transaction->mahasiswa->jurusan ?? '-' }}</td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">Kelas</td><td>{{ $transaction->mahasiswa->kelas ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title">📚 Info Buku</span></div>
        <table style="font-size:.85rem;">
            <tr><td style="color:var(--text-muted);padding:6px 0;width:130px;">Nama Buku</td><td><strong>{{ $transaction->book->nama_buku ?? '-' }}</strong></td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">Pengarang</td><td>{{ $transaction->book->pengarang ?? '-' }}</td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">Penerbit</td><td>{{ $transaction->book->penerbit ?? '-' }}</td></tr>
            <tr><td style="color:var(--text-muted);padding:6px 0;">Kategori</td><td>{{ $transaction->book->kategori ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="card" style="grid-column:1/-1;">
        <div class="card-header"><span class="card-title">🔄 Info Peminjaman</span></div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
            <div>
                <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Tgl Pinjam</div>
                <div style="font-weight:700;">{{ $transaction->tanggal_pinjam?->format('d M Y') }}</div>
            </div>
            <div>
                <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Batas Kembali</div>
                <div style="font-weight:700;">{{ $transaction->tanggal_pinjam?->addDays(7)->format('d M Y') }}</div>
            </div>
            <div>
                <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Tgl Kembali</div>
                <div style="font-weight:700;">{{ $transaction->tanggal_kembali?->format('d M Y') ?? '-' }}</div>
            </div>
            <div>
                <div style="font-size:.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Denda</div>
                <div style="font-weight:700;color:{{ $transaction->denda > 0 ? 'var(--danger)' : 'var(--success)' }};">
                    {{ $transaction->denda > 0 ? 'Rp ' . number_format($transaction->denda, 0, ',', '.') : 'Tidak ada' }}
                </div>
            </div>
        </div>
        <div style="margin-top:20px;display:flex;align-items:center;gap:12px;">
            <span class="badge badge-{{ $transaction->status }}" style="font-size:.85rem;padding:6px 14px;">{{ ucfirst($transaction->status) }}</span>
            @if($transaction->status === 'menunggu')
            <form action="{{ route('admin.transactions.update', $transaction->id_transaksi) }}" method="POST" onsubmit="return confirm('Setujui peminjaman ini?')">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="dipinjam">
                <button type="submit" class="btn btn-success" id="btn-setujui-admin">✓ Setujui</button>
            </form>
            <form action="{{ route('admin.transactions.update', $transaction->id_transaksi) }}" method="POST" onsubmit="return confirm('Tolak peminjaman ini?')">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <button type="submit" class="btn btn-danger" id="btn-tolak-admin">✕ Tolak</button>
            </form>
            @elseif($transaction->status === 'dipinjam')
            <form action="{{ route('admin.transactions.update', $transaction->id_transaksi) }}" method="POST" onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="selesai">
                <button type="submit" class="btn btn-success" id="btn-kembalikan-admin">✓ Tandai Dikembalikan</button>
            </form>
            @endif
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-ghost">← Kembali</a>
        </div>
    </div>
</div>
@endsection

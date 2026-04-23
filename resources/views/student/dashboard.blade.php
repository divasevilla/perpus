@extends('layouts.app')
@section('title', 'Dashboard')
@section('sidebar-role', 'Portal Siswa')
@section('breadcrumb', 'Student')
@section('page-title', 'Dashboard')
@include('student._sidebar')

@section('content')
<!-- Greeting -->
<div style="margin-bottom:24px;">
    <h3 style="font-size:1.2rem;font-weight:700;">Halo, {{ auth()->user()->mahasiswa->nama_lengkap ?? auth()->user()->name }}! 👋</h3>
    <p style="color:var(--text-muted);font-size:.875rem;margin-top:4px;">
        NIM: {{ auth()->user()->mahasiswa->nim ?? '-' }} &bull; {{ auth()->user()->mahasiswa->prodi ?? '-' }}
    </p>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange">📖</div>
        <div class="stat-info">
            <p>{{ $sedang_pinjam }}</p>
            <span>Aktif / Menunggu</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">📚</div>
        <div class="stat-info">
            <p>{{ $total_pinjam }}</p>
            <span>Total Pinjam</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon {{ $total_denda > 0 ? 'red' : 'green' }}">
            {{ $total_denda > 0 ? '⚠️' : '✅' }}
        </div>
        <div class="stat-info">
            <p style="font-size:1.1rem;">{{ $total_denda > 0 ? 'Rp ' . number_format($total_denda, 0, ',', '.') : 'Nihil' }}</p>
            <span>Total Denda</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">🎯</div>
        <div class="stat-info">
            <p>{{ 3 - $sedang_pinjam }}</p>
            <span>Sisa Slot Pinjam</span>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
    <!-- Riwayat -->
    <div class="card" style="grid-column:1/-1;">
        <div class="card-header">
            <span class="card-title">Riwayat Terakhir</span>
            <a href="{{ route('student.transactions.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        @if($riwayat->isEmpty())
            <div style="text-align:center;padding:32px;color:var(--text-muted);">
                <div style="font-size:2rem;margin-bottom:8px;">📚</div>
                <p>Belum pernah meminjam buku.</p>
                <a href="{{ route('student.books.index') }}" class="btn btn-primary" style="margin-top:12px;display:inline-flex;">Lihat Katalog Buku</a>
            </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $t)
                    <tr>
                        <td><strong>{{ $t->book->nama_buku ?? '-' }}</strong></td>
                        <td>{{ $t->tanggal_pinjam?->format('d M Y') }}</td>
                        <td>
                            @php $batas = $t->tanggal_pinjam?->addDays(7); @endphp
                            <span style="{{ $t->status === 'dipinjam' && $batas?->isPast() ? 'color:var(--danger);font-weight:600;' : '' }}">
                                {{ $batas?->format('d M Y') }}
                            </span>
                        </td>
                        <td><span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                        <td>{{ $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

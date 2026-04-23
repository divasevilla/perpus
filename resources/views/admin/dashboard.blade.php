@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin')
@section('page-title', 'Dashboard')

@section('sidebar-nav')
    <div class="nav-section-label">Menu Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
    </a>

    <div class="nav-section-label">Manajemen</div>
    <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        Kelola Buku
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="nav-link {{ request()->routeIs('admin.transactions*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        Transaksi
    </a>
    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Laporan
    </a>
    <a href="{{ route('admin.members.index') }}" class="nav-link {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Kelola Anggota
    </a>
@endsection

@section('content')
<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">📚</div>
        <div class="stat-info">
            <p>{{ $total_buku }}</p>
            <span>Total Buku</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">👥</div>
        <div class="stat-info">
            <p>{{ $total_anggota }}</p>
            <span>Total Anggota</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🔄</div>
        <div class="stat-info">
            <p>{{ $total_pinjam }}</p>
            <span>Aktif / Menunggu</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">✅</div>
        <div class="stat-info">
            <p>{{ $total_kembali }}</p>
            <span>Sudah Dikembalikan</span>
        </div>
    </div>
    @if($stok_habis > 0)
    <div class="stat-card">
        <div class="stat-icon red">⚠️</div>
        <div class="stat-info">
            <p>{{ $stok_habis }}</p>
            <span>Stok Habis</span>
        </div>
    </div>
    @endif
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header">
        <span class="card-title">Transaksi Terbaru</span>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
    </div>

    @if($transaksi_terbaru->isEmpty())
        <p style="color:var(--text-muted);text-align:center;padding:24px;">Belum ada transaksi.</p>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi_terbaru as $t)
                <tr>
                    <td>{{ $t->mahasiswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $t->book->nama_buku ?? '-' }}</td>
                    <td>{{ $t->tanggal_pinjam?->format('d M Y') }}</td>
                    <td><span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    <td>{{ $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

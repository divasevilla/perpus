@extends('layouts.app')
@section('title', 'Peminjaman Buku')
@section('sidebar-role', 'Portal Siswa')
@section('breadcrumb', 'Student / Peminjaman Buku')
@section('page-title', 'Peminjaman Buku')
@include('student._sidebar')

@section('content')
<!-- Filter & Search -->
<form method="GET" style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    <input type="text" name="search" class="form-control" style="max-width:260px;" placeholder="Cari judul, pengarang..." value="{{ request('search') }}">
    <select name="kategori" class="form-control" style="max-width:180px;">
        <option value="">Semua Kategori</option>
        @foreach($kategori as $k)
            <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-ghost">Filter</button>
    @if(request()->hasAny(['search','kategori']))
        <a href="{{ route('student.books.index') }}" class="btn btn-ghost">Reset</a>
    @endif
</form>

<!-- Books Grid -->
@if($books->isEmpty())
    <div style="text-align:center;padding:64px;color:var(--text-muted);">
        <div style="font-size:3rem;margin-bottom:12px;">🔍</div>
        <p>Tidak ada buku yang ditemukan.</p>
    </div>
@else
<div class="books-grid">
    @foreach($books as $book)
    <div class="book-card">
        <div class="book-cover" style="background:linear-gradient(135deg,
            {{ ['#6366f1,#a855f7','#0ea5e9,#06b6d4','#10b981,#059669','#f59e0b,#ef4444','#ec4899,#8b5cf6'][($book->id_buku % 5)] }}
        );">
            📖
        </div>
        <div>
            <div class="book-title">{{ $book->nama_buku }}</div>
            <div class="book-author">{{ $book->pengarang }}</div>
            <div style="font-size:.72rem;color:var(--text-muted);margin-bottom:8px;">{{ $book->penerbit }} · {{ $book->tahun_terbit }}</div>
        </div>
        <div class="book-meta">
            <span class="badge" style="background:rgba(99,102,241,0.15);color:#818cf8;">{{ $book->kategori }}</span>
            <span class="stok-tag {{ $book->stok_buku > 0 ? 'stok-ada' : 'stok-habis' }}">
                {{ $book->stok_buku > 0 ? 'Stok: ' . $book->stok_buku : 'Habis' }}
            </span>
        </div>
        @if($book->stok_buku > 0)
        <form action="{{ route('student.transactions.store') }}" method="POST" style="margin-top:12px;">
            @csrf
            <input type="hidden" name="id_buku" value="{{ $book->id_buku }}">
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;" id="btn-pinjam-{{ $book->id_buku }}"
                onclick="return confirm('Pinjam buku &quot;{{ addslashes($book->nama_buku) }}&quot;?')">
                Pinjam Buku
            </button>
        </form>
        @else
        <button class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:12px;opacity:.5;cursor:not-allowed;" disabled>
            Stok Habis
        </button>
        @endif
    </div>
    @endforeach
</div>

@if($books->hasPages())
    <div style="margin-top:24px;">{{ $books->links() }}</div>
@endif
@endif
@endsection

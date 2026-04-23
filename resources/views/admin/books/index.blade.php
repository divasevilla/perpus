@extends('layouts.app')
@section('title', 'Kelola Buku')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Buku')
@section('page-title', 'Kelola Buku')
@include('admin._sidebar')

@section('topbar-actions')
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary" id="btn-tambah-buku">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Buku
    </a>
@endsection

@section('content')
<!-- Search -->
<form method="GET" style="margin-bottom:16px;display:flex;gap:10px;">
    <input type="text" name="search" class="form-control" style="max-width:300px;" placeholder="Cari buku, pengarang..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-ghost">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.books.index') }}" class="btn btn-ghost">Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Buku</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>{{ $books->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $book->nama_buku }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $book->penerbit }}</div>
                    </td>
                    <td>{{ $book->pengarang }}</td>
                    <td><span class="badge" style="background:rgba(99,102,241,0.15);color:#818cf8;">{{ $book->kategori }}</span></td>
                    <td>{{ $book->tahun_terbit }}</td>
                    <td>
                        <span class="badge {{ $book->stok_buku > 0 ? 'badge-kembali' : 'badge-pinjam' }}">
                            {{ $book->stok_buku }} buku
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.books.edit', $book->id_buku) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book->id_buku) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px;">
                        Belum ada buku. <a href="{{ route('admin.books.create') }}" style="color:var(--primary);">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <div class="pagination">
            {!! $books->links('pagination::simple-bootstrap-4') !!}
        </div>
    @endif
</div>
@endsection

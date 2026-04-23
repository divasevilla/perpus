@extends('layouts.app')
@section('title', 'Edit Buku')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Buku / Edit')
@section('page-title', 'Edit Buku')
@include('admin._sidebar')

@section('content')
<div class="card" style="max-width:640px;">
    <form action="{{ route('admin.books.update', $book->id_buku) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="nama_buku">Nama Buku</label>
                <input id="nama_buku" type="text" name="nama_buku" class="form-control" value="{{ old('nama_buku', $book->nama_buku) }}" required>
                @error('nama_buku')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="pengarang">Pengarang</label>
                <input id="pengarang" type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $book->pengarang) }}" required>
                @error('pengarang')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="penerbit">Penerbit</label>
                <input id="penerbit" type="text" name="penerbit" class="form-control" value="{{ old('penerbit', $book->penerbit) }}" required>
                @error('penerbit')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="kategori">Kategori</label>
                <input id="kategori" type="text" name="kategori" class="form-control" value="{{ old('kategori', $book->kategori) }}" required>
                @error('kategori')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                <input id="tahun_terbit" type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" required>
                @error('tahun_terbit')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="stok_buku">Stok Buku</label>
                <input id="stok_buku" type="number" name="stok_buku" class="form-control" value="{{ old('stok_buku', $book->stok_buku) }}" min="0" required>
                @error('stok_buku')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn btn-primary" id="btn-update-buku">Update Buku</button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection

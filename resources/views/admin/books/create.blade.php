@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Buku / Tambah')
@section('page-title', 'Tambah Buku Baru')
@include('admin._sidebar')

@section('content')
<div class="card" style="max-width:640px;">
    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="nama_buku">Nama Buku</label>
                <input id="nama_buku" type="text" name="nama_buku" class="form-control" value="{{ old('nama_buku') }}" placeholder="Judul buku" required>
                @error('nama_buku')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="pengarang">Pengarang</label>
                <input id="pengarang" type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}" placeholder="Nama penulis" required>
                @error('pengarang')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="penerbit">Penerbit</label>
                <input id="penerbit" type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                @error('penerbit')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="kategori">Kategori</label>
                <input id="kategori" type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" placeholder="Teknologi, Novel, dll" required>
                @error('kategori')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                <input id="tahun_terbit" type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
                @error('tahun_terbit')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="stok_buku">Stok Buku</label>
                <input id="stok_buku" type="number" name="stok_buku" class="form-control" value="{{ old('stok_buku', 1) }}" min="0" required>
                @error('stok_buku')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn btn-primary" id="btn-simpan-buku">Simpan Buku</button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection

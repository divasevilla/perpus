@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Anggota / Edit')
@section('page-title', 'Edit Anggota')
@include('admin._sidebar')

@section('content')
<div class="card" style="max-width:640px;">
    <form action="{{ route('admin.members.update', $member->id_mahasiswa) }}" method="POST">
        @csrf @method('PUT')
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Akun Login</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label" for="name">Nama Pengguna</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $member->user->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $member->user->email) }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="password">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Min. 6 karakter">
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="height:1px;background:var(--border);margin:8px 0 16px;"></div>
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Mahasiswa</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label" for="nim">NIM</label>
                <input id="nim" type="text" name="nim" class="form-control" value="{{ old('nim', $member->nim) }}" required>
                @error('nim')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $member->nama_lengkap) }}" required>
                @error('nama_lengkap')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="jurusan">Jurusan</label>
                <input id="jurusan" type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $member->jurusan) }}" required>
                @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="prodi">Program Studi</label>
                <input id="prodi" type="text" name="prodi" class="form-control" value="{{ old('prodi', $member->prodi) }}" required>
                @error('prodi')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="no_telepon">No. Telepon</label>
                <input id="no_telepon" type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $member->no_telepon) }}" required>
                @error('no_telepon')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="alamat">Alamat</label>
                <input id="alamat" type="text" name="alamat" class="form-control" value="{{ old('alamat', $member->alamat) }}" required>
                @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn btn-primary" id="btn-update-anggota">Update Anggota</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection

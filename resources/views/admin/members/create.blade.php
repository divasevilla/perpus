@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Anggota / Tambah')
@section('page-title', 'Tambah Anggota Baru')
@include('admin._sidebar')

@section('content')
<div class="card" style="max-width:640px;">
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Akun Login</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label" for="name">Nama Pengguna</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="height:1px;background:var(--border);margin:8px 0 16px;"></div>
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Siswa</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label" for="nisn">NISN</label>
                <input id="nisn" type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" required>
                @error('nisn')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="jurusan">Jurusan</label>
                <select id="jurusan" name="jurusan" class="form-control" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="RPL" {{ old('jurusan') === 'RPL' ? 'selected' : '' }}>RPL</option>
                    <option value="TPL" {{ old('jurusan') === 'TPL' ? 'selected' : '' }}>TPL</option>
                    <option value="TO" {{ old('jurusan') === 'TO' ? 'selected' : '' }}>TO</option>
                    <option value="BC" {{ old('jurusan') === 'BC' ? 'selected' : '' }}>BC</option>
                    <option value="ANIM" {{ old('jurusan') === 'ANIM' ? 'selected' : '' }}>ANIM</option>
                </select>
                @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="kelas">Kelas</label>
                <select id="kelas" name="kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    <option value="10" {{ old('kelas') === '10' ? 'selected' : '' }}>10</option>
                    <option value="11" {{ old('kelas') === '11' ? 'selected' : '' }}>11</option>
                    <option value="12" {{ old('kelas') === '12' ? 'selected' : '' }}>12</option>
                </select>
                @error('kelas')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="alamat">Alamat</label>
                <input id="alamat" type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
                @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn btn-primary" id="btn-simpan-anggota">Simpan Anggota</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection

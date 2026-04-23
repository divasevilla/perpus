@extends('layouts.auth')
@section('title', 'Daftar Anggota')
@section('content')

<div class="auth-box" style="max-width:520px;">
    <div class="auth-logo">
        <span class="icon">📚</span>
        <h1>Daftar Anggota</h1>
        <p>Buat akun perpustakaan kamu</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="list-style:none;margin:0;">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Akun</p>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">Nama Pengguna</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="nisn">NISN</label>
                <input id="nisn" type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" placeholder="1234567890" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>

        <div style="height:1px;background:var(--border);margin:16px 0;"></div>
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">Info Siswa</p>

        <div class="form-group">
            <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Sesuai Kartu Pelajar" required>
        </div>
        <div class="form-row">
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
            </div>
            <div class="form-group">
                <label class="form-label" for="kelas">Kelas</label>
                <select id="kelas" name="kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    <option value="10" {{ old('kelas') === '10' ? 'selected' : '' }}>10</option>
                    <option value="11" {{ old('kelas') === '11' ? 'selected' : '' }}>11</option>
                    <option value="12" {{ old('kelas') === '12' ? 'selected' : '' }}>12</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="alamat">Alamat</label>
            <input id="alamat" type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Kota, Provinsi" required>
        </div>

        <button type="submit" class="btn-primary" id="btn-register" style="margin-top:8px;">Daftar Sekarang →</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</div>

@endsection

@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Anggota / Edit')
@section('page-title', 'Edit Anggota')

@include('admin._sidebar')

@section('content')
<div class="card" style="max-width:640px;">
    <form action="{{ route('admin.members.update', $member->id_mahasiswa) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- INFO AKUN --}}
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">
            Info Akun Login
        </p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $member->user->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $member->user->email) }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">
                    Password Baru
                    <span style="color:var(--text-muted);font-weight:400;">
                        (kosongkan jika tidak diubah)
                    </span>
                </label>
                <input type="password" name="password" class="form-control">
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- 🔥 ALAMAT --}}
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control"
                    value="{{ old('alamat', $member->alamat) }}" required>
                @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="height:1px;background:var(--border);margin:16px 0;"></div>

        {{-- INFO MAHASISWA --}}
        <p style="font-size:.75rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;">
            Info Mahasiswa
        </p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">NISN</label>
                <input type="text" name="nisn" class="form-control"
                    value="{{ old('nisn', $member->nisn) }}" required>
                @error('nisn')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control"
                    value="{{ old('nama_lengkap', $member->nama_lengkap) }}" required>
                @error('nama_lengkap')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- JURUSAN --}}
            <div class="form-group">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-control" required>
                    <option value="">Pilih Jurusan</option>
                    @foreach(['RPL','TPL','TO','BC','ANIM'] as $j)
                        <option value="{{ $j }}"
                            {{ old('jurusan', $member->jurusan) == $j ? 'selected' : '' }}>
                            {{ $j }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            {{-- KELAS --}}
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach(['10','11','12'] as $k)
                        <option value="{{ $k }}"
                            {{ old('kelas', $member->kelas) == $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach
                </select>
                @error('kelas')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:16px;">
            <button type="submit" class="btn btn-primary">
                Update Anggota
            </button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-ghost">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
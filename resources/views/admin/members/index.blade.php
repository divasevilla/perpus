@extends('layouts.app')
@section('title', 'Kelola Anggota')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Anggota')
@section('page-title', 'Kelola Anggota')
@include('admin._sidebar')

@section('topbar-actions')
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        + Tambah Anggota
    </a>
@endsection

@section('content')
<form method="GET" style="margin-bottom:16px;display:flex;gap:10px;">
    <input type="text" name="search" class="form-control" style="max-width:300px;" placeholder="Cari nama, NISN, jurusan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-ghost">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.members.index') }}" class="btn btn-ghost">Reset</a>
    @endif
</form>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NISN</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Alamat</th> {{-- 🔥 TAMBAHAN --}}
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>{{ $members->firstItem() + $loop->index }}</td>

                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;">
                                {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                            </div>
                            <strong>{{ $member->nama_lengkap }}</strong>
                        </div>
                    </td>

                    <td>{{ $member->nisn }}</td>
                    <td>{{ $member->jurusan }}</td>
                    <td>{{ $member->kelas }}</td> {{-- 🔥 FIX --}}
                    <td>{{ $member->alamat }}</td> {{-- 🔥 TAMBAHAN --}}
                    <td>{{ $member->user->email ?? '-' }}</td>

                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.members.edit', $member->id_mahasiswa) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.members.destroy', $member->id_mahasiswa) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:20px;">
                        Belum ada anggota
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
        <div style="margin-top:16px;">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
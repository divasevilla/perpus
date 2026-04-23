@extends('layouts.app')
@section('title', 'Kelola Anggota')
@section('sidebar-role', 'Panel Admin')
@section('breadcrumb', 'Admin / Anggota')
@section('page-title', 'Kelola Anggota')
@include('admin._sidebar')

@section('topbar-actions')
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary" id="btn-tambah-anggota">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Anggota
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
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;flex-shrink:0;">
                                {{ strtoupper(substr($member->nama_lengkap, 0, 1)) }}
                            </div>
                            <strong>{{ $member->nama_lengkap }}</strong>
                        </div>
                    </td>
                    <td>{{ $member->nim }}</td>
                    <td>
                        <div>{{ $member->jurusan }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);">{{ $member->prodi }}</div>
                    </td>
                    <td>{{ $member->no_telepon }}</td>
                    <td>{{ $member->user->email ?? '-' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.members.edit', $member->id_mahasiswa) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.members.destroy', $member->id_mahasiswa) }}" method="POST" onsubmit="return confirm('Hapus anggota ini? Data login juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px;">
                        Belum ada anggota. <a href="{{ route('admin.members.create') }}" style="color:var(--primary);">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($members->hasPages())
        <div style="margin-top:16px;">{{ $members->links() }}</div>
    @endif
</div>
@endsection

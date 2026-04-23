<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
        }

        $members = $query->paginate(10)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'nisn'         => 'required|string|unique:mahasiswas,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jurusan'      => 'required|string|in:RPL,TPL,TO,BC,ANIM',
            'kelas'        => 'required|string|in:10,11,12',
            'alamat'       => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);

        Mahasiswa::create([
            'user_id'      => $user->id,
            'nisn'         => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jurusan'      => $request->jurusan,
            'kelas'        => $request->kelas,
            'alamat'       => $request->alamat,
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $member)
    {
        $member->load('user');
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Mahasiswa $member)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $member->user_id,
            'nisn'         => 'required|string|unique:mahasiswas,nisn,' . $member->id_mahasiswa . ',id_mahasiswa',
            'nama_lengkap' => 'required|string|max:255',
            'jurusan'      => 'required|string|in:RPL,TPL,TO,BC,ANIM',
            'kelas'        => 'required|string|in:10,11,12',
            'alamat'       => 'required|string',
        ]);

        $member->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $member->user->update(['password' => Hash::make($request->password)]);
        }

        $member->update([
            'nisn'         => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jurusan'      => $request->jurusan,
            'kelas'        => $request->kelas,
            'alamat'       => $request->alamat,
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $member)
    {
        $member->user->delete(); // cascade delete mahasiswa
        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}

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
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'alamat' => 'required|string|max:255',
            'nisn' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'jurusan' => 'required',
            'kelas' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    // 🔥 EDIT
    public function edit($id)
    {
        $member = Mahasiswa::with('user')->findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    // 🔥 UPDATE (INI YANG BELUM ADA TADI)
    public function update(Request $request, $id)
    {
        $member = Mahasiswa::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->user->id,
            'alamat' => 'required|string|max:255',
            'nisn' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'jurusan' => 'required',
            'kelas' => 'required',
        ]);

        // update user
        $member->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // update mahasiswa
        $member->update([
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Data berhasil diupdate!');
    }

    // 🔥 DELETE (BIAR TOMBOL HAPUS JALAN)
    public function destroy($id)
    {
        $member = Mahasiswa::with('user')->findOrFail($id);

        // hapus user juga
        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}
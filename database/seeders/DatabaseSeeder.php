<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@perpus.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Sample student account
        $student = User::create([
            'name'     => 'Diva Sevilla',
            'email'    => 'diva@student.com',
            'password' => Hash::make('diva123'),
            'role'     => 'student',
        ]);

        Mahasiswa::create([
            'user_id'      => $student->id,
            'nisn'         => '00072444',
            'nama_lengkap' => 'Diva Sevilla',
            'jurusan'      => 'RPL', 
            'kelas'        => '12'      
          ]);

        // Sample books
        $books = [
            ['nama_buku' => 'Laravel: Up & Running', 'pengarang' => 'Matt Stauffer', 'penerbit' => 'O\'Reilly Media', 'tahun_terbit' => 2022, 'stok_buku' => 5, 'kategori' => 'Teknologi'],
            ['nama_buku' => 'Clean Code', 'pengarang' => 'Robert C. Martin', 'penerbit' => 'Prentice Hall', 'tahun_terbit' => 2008, 'stok_buku' => 3, 'kategori' => 'Teknologi'],
            ['nama_buku' => 'The Pragmatic Programmer', 'pengarang' => 'David Thomas', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2019, 'stok_buku' => 4, 'kategori' => 'Teknologi'],
            ['nama_buku' => 'Bumi', 'pengarang' => 'Tere Liye', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2014, 'stok_buku' => 6, 'kategori' => 'Novel'],
            ['nama_buku' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'stok_buku' => 8, 'kategori' => 'Novel'],
            ['nama_buku' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Avery', 'tahun_terbit' => 2018, 'stok_buku' => 5, 'kategori' => 'Self Development'],
            ['nama_buku' => 'Pengantar Algoritma', 'pengarang' => 'Thomas H. Cormen', 'penerbit' => 'MIT Press', 'tahun_terbit' => 2009, 'stok_buku' => 2, 'kategori' => 'Teknologi'],
            ['nama_buku' => 'Matematika Diskrit', 'pengarang' => 'Kenneth Rosen', 'penerbit' => 'McGraw-Hill', 'tahun_terbit' => 2018, 'stok_buku' => 3, 'kategori' => 'Matematika'],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}

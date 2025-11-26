<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Arcadia',
            'email' => 'admin@arcadia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Peminjam contoh
        User::create([
            'name' => 'John Doe',
            'email' => 'john@arcadia.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@arcadia.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
        ]);

        // Buku contoh
        Book::create(['title'=>'Buku Laravel','author'=>'Author A','stock'=>5]);
        Book::create(['title'=>'Buku PHP','author'=>'Author B','stock'=>3]);
        Book::create(['title'=>'Buku Database','author'=>'Author C','stock'=>2]);
        Book::create(['title'=>'Buku JavaScript','author'=>'Author D','stock'=>4]);
        Book::create(['title'=>'Buku Algoritma','author'=>'Author E','stock'=>1]);
    }
}

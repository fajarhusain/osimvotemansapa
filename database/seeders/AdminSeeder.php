<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Periksa apakah akun admin sudah ada untuk menghindari duplikasi
        if (Admin::where('username', 'admin')->doesntExist()) {
            Admin::create([
                'nama' => 'Fajar Husain',
                'username' => 'admin',
                // 'email' => 'admin@patitech.id', // 
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
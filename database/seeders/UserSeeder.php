<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data Guru
        User::create([
            'name'     => 'Budi Santoso',
            'nip'      => '198501012010011001',
            'role'     => 'guru',
            'password' => Hash::make('guru123'),
        ]);

        // Data Siswa
        User::create([
            'name'     => 'Andi Pratama',
            'nis'      => '2024001',
            'role'     => 'siswa',
            'kelas'    => 'X-A',
            'password' => Hash::make('siswa123'),
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'nis'      => '2024002',
            'role'     => 'siswa',
            'kelas'    => 'X-B',
            'password' => Hash::make('siswa123'),
        ]);
    }
}

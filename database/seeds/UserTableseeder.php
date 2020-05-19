<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\User::create([
        'nama'=> 'admin',
        'email'=> 'admin@gmail.com',
        'password' => Hash::make('admin'),
        'id'=> Str::uuid(),
        'nik'=>'0000',
        'alamat'=>'Bangil',
        'domisili'=>'Bangil',
        'kelamin'=>'L',
        'no_telepon'=>'00000000000',
        'jabatan'=>'Manager',
        'dept'=>'Admin',
        'group'=>'Admin',
        'section'=>'Admin',
        'status_karyawan'=>'tetap',
        
       ]);
    }
}

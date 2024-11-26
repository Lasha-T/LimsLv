<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Guest',
            'email' => 'Adminguest@example.com',
            'password' => Hash::make('1234'),
            'role' => 'adminguest',
        ]);
    }
}

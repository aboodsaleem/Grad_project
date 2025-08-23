<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('users')->insert([[

        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'admin',
        'status' => 'active',
    ],[

        'username' => 'service_provider',
        'email' => 'serviceprovider@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'service_provider',
        'status' => 'active',
    ],[

        'username' => 'customer',
        'email' => 'customer@gmail.com',
        'password' => Hash::make('123456'),
        'role' => 'customer',
        'status' => 'active',
    ]]);
    }
}

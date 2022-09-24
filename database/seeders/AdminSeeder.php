<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'administrator',
                'password' => Hash::make('123456'),
                'role' => 'ADMIN',
            ],
            [
                'username' => 'jury1',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
            [
                'username' => 'jury2',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
            [
                'username' => 'jury3',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
            [
                'username' => 'jury4',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
            [
                'username' => 'jury5',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
            [
                'username' => 'jury6',
                'password' => Hash::make('123456'),
                'role' => 'JURY',
            ],
        ];

        foreach ($data as $admin) {
            Admin::create($admin);
        }
    }
}

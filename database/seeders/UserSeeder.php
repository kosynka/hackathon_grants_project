<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Арманов Арман Арманович',
                'iin' => '990102000999',
                'phone' => '777 888 9999',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Бериков Берик Берикович',
                'iin' => '000101887766',
                'phone' => '777 000 1111',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Айдынова Айжан Айдыновна',
                'iin' => '010101554433',
                'phone' => '700 700 8080',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Ярослав Яросл Ерасылович',
                'iin' => '021022558888',
                'phone' => '775 513 8888',
                'email' => 'strong_era@mail.ru',
                'password' => Hash::make('123'),
            ],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}

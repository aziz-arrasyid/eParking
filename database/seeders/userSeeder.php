<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0 = admin, 1 = jukir
        $dataUsers = [
            [
                'username' => 'eParking',
                'role' => '0',
                'password' => bcrypt('SMKN4'),
            ],
            // [
            //     'username' => 'jukir',
            //     'role' => '1',
            //     'password' => bcrypt('jukir'),
            // ],
        ];

        foreach($dataUsers as $dataUser)
        {
            User::create($dataUser);
        }
    }
}

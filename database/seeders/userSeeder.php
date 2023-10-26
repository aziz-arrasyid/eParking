<?php

namespace Database\Seeders;

use App\Models\Jukir;
use App\Models\Parkir;
use App\Models\Transport;
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

        // $dataTransports = [
        //     [
        //         'jenisKendaraan' => 'Mobil',
        //         'hargaParkir' => 200,
        //     ],
        // ];

        // foreach($dataTransports as $dataTransport)
        // {
        //     Transport::create($dataTransport);
        // }

        // $dataJukirs = [
        //     [
        //         'name' => 'aziz',
        //         'age' => '17',
        //         'phoneNumber' => '081218122006',
        //         'user_id' => 2,
        //     ],
        // ];

        // foreach($dataJukirs as $dataJukir)
        // {
        //     Jukir::create($dataJukir);
        // }

        // // Gantilah 'Model' dengan nama model yang sesuai
        // foreach (range(1, 10000) as $index) {
        //     Parkir::create([
        //         'no_plat' => 'BP 12 QW',
        //         'transport_id' => 1,
        //         'jukir_id' => 1,
        //         'status' => 'unpaid',
        //         'payment_type' => 'cash',
        //         // Tambahkan kolom lain sesuai kebutuhan Anda
        //     ]);
        // }


    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->delete();

        $users = [
            // Admin
            [
                'name'	        => 'Admin',
                'email'         => 'admin@ecommerce.com',
                'password'      => '$2y$10$QNf5iYdhmFxVn7OMrtZJQemkt46VPLZtGmU6ncJk3LERyd1r/zSqW', // Encrypted password is: adminpass
            ],
            // Client
            [
                'name'          => 'Client',
                'email'         => 'client@ecommerce.com',
                'password'      => '$2y$10$xxgI.2pRrN1H6LuxYJz.0.653AyqU4E1302xe.N4MOhv3uHM0Uqo2', // Encrypted password is: clientpass
            ],
        ];
        $attributes = [
            [
                'name'	        => 'name',
                'label'         =>'nom'

            ],
            [
                'name'	        => 'email',
                'label'         =>'adress mail '

            ],
            [
                'name'	        => 'phoneNumber',
                'label'         =>'Numero de telephone '

            ],

        ];

        DB::table('users')->insert($users);
    }
}

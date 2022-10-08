<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
            'id'             => 1,
            'firstname'      => 'Admin',
			'lastname'     => 'Admin',
			'username'    => 'admin',
			'email'      => 'admin1@gmail.com',
            'password'       => bcrypt('password'),
            'avatar'        => 'avatar.png',
			'phone'      => '0123456789',
			'role_id'     => 1,
			'statut'    => 1,
            'is_all_warehouses' => 1,
                'remember_token' => null,
                'created_at' => now(),
            ],
        ];

        User::insert($users);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'IsAdmin' => '1',
                'password' => bcrypt('1234'),
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'IsAdmin' => '0',
                'password' => bcrypt('1234'),
            ]
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}

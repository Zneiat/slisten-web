<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            0 => [
                'id'             => 1,
                'name'           => 'god',
                'email'          => 'god@example.com',
                'password'       => bcrypt('god'),
                'remember_token' => null,
                'created_at'     => '2017-11-29 21:35:00',
                'updated_at'     => '2017-11-29 21:35:00',
                'role'           => User::ROLE_GOD,
            ],
            1 => [
                'id'             => 2,
                'name'           => 'admin',
                'email'          => 'admin@example.com',
                'password'       => bcrypt('admin'),
                'remember_token' => null,
                'created_at'     => '2017-11-29 21:35:00',
                'updated_at'     => '2017-11-29 21:35:00',
                'role'           => User::ROLE_ADMIN,
            ],
            2 => [
                'id'             => 3,
                'name'           => 'Zneiat',
                'email'          => 'Zneiat@example.com',
                'password'       => bcrypt('zneiat'),
                'remember_token' => null,
                'created_at'     => '2017-11-17 15:21:31',
                'updated_at'     => '2017-11-17 15:21:31',
                'role'           => User::ROLE_ADMIN,
            ],
            3 => [
                'id'             => 4,
                'name'           => 'qwqaq',
                'email'          => 'qwqaq@example.com',
                'password'       => bcrypt('qwqaq'),
                'remember_token' => null,
                'created_at'     => '2017-11-11 11:42:11',
                'updated_at'     => '2017-11-11 11:42:11',
                'role'           => User::ROLE_USER,
            ],
            4 => [
                'id'             => 5,
                'name'           => 'test',
                'email'          => 'test@example.com',
                'password'       => bcrypt('test'),
                'remember_token' => null,
                'created_at'     => '2017-11-11 11:42:11',
                'updated_at'     => '2017-11-11 11:42:11',
                'role'           => User::ROLE_USER,
            ],
        ]);
    }
}

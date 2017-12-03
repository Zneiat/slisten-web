<?php

use Illuminate\Database\Seeder;

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
                'name'           => 'admin',
                'email'          => 'admin@example.com',
                'password'       => bcrypt('admin'),
                'remember_token' => null,
                'created_at'     => '2017-11-29 21:35:00',
                'updated_at'     => '2017-11-29 21:35:00',
                'role'           => '20',
            ],
            1 => [
                'id'             => 2,
                'name'           => 'zneiat',
                'email'          => 'zneiat@example.com',
                'password'       => bcrypt('zneiat'),
                'remember_token' => null,
                'created_at'     => '2017-11-17 15:21:31',
                'updated_at'     => '2017-11-17 15:21:31',
                'role'           => '10',
            ],
            2 => [
                'id'             => 3,
                'name'           => 'qwqaq',
                'email'          => 'qwqaq@example.com',
                'password'       => bcrypt('qwqaq'),
                'remember_token' => null,
                'created_at'     => '2017-11-11 11:42:11',
                'updated_at'     => '2017-11-11 11:42:11',
                'role'           => '10',
            ],
        ]);
    }
}

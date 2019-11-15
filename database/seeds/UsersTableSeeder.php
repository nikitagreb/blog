<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    private const TABLE = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(static::TABLE)->truncate();
        $users = [
            [
                'name' => 'Nikita' ,
                'email' => 'nikitagreb0204@mail.ru' ,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Andrey' ,
                'email' => 'a@fandb.pro' ,
                'password' => Hash::make('password'),
            ]
        ];

        foreach ($users as $user) {
            $user['remember_token'] = Str::random(10);
            $user['email_verified_at'] = now();
            $user['created_at'] = now();
            $user['updated_at'] = now();
            DB::table(static::TABLE)->insert($user);
        }
    }
}

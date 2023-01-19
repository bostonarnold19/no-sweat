<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\User\Entities\User;
use Illuminate\Auth\Events\Registered;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password'=> bcrypt('admin'),
        ]);

        event(new Registered($user));

        User::factory(100)->create();
    }
}

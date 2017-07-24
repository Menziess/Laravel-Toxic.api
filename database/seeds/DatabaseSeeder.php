<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        App\User::create([
            'first_name' => 'Anonymous',
            'last_name' => '',
            'email' => 't-o-x-i-c@outlook.com',
        ]);
    }
}

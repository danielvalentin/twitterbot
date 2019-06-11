<?php

use Illuminate\Database\Seeder;

use App\User;

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
        App\User::create([
			'name' => 'daniel',
			'email' => 'saktomail@gmail.com',
			'password' => bcrypt('danielv')
		]);
    }
}

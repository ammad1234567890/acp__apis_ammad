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

        $this->call([
            tbl_role_seeder::class,
            tbl_country_seeder::class,
            tbl_state_seeder::class,
            tbl_city_seeder::class,
        ]);

        factory(App\User::class, 10)->create();
    }
}

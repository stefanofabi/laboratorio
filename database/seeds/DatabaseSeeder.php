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
        $this->call(UserSeeder::class);
        
        $this->call(PatientsSeeder::class);

        $this->call(PrescriberSeeder::class);

        $this->call(NomenclatorSeeder::class);

        $this->call(SocialWorkSeeder::class);
        
        $this->call(PlanSeeder::class);
    }
}

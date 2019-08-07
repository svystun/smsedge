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
        $this->call(Countries::class);
        $this->call(Users::class);
        $this->call(Numbers::class);
        $this->call(SendLog::class);
    }
}

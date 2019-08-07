<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = [];
        for ($j = 0; $j < 50; $j++) {
            $users[] = [
                'usr_name' => $faker->name,
                'usr_active' => 1,
                'usr_created' => date('Y-m-d')
            ];
        }

        App\UserLog::insert($users);
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class Numbers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $countries = \App\Country::all()->pluck('cnt_id')->toArray();
        $numbers = [];

        for ($j = 0; $j < 50; $j++) {
            $numbers[] = [
                'cnt_id' => array_random($countries),
                'num_number' => $faker->e164PhoneNumber,
                'num_created' => date('Y-m-d')
            ];
        }

        App\Number::insert($numbers);
    }
}

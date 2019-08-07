<?php

use App\LogGlobal;
use App\Number;
use App\UserLog;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SendLog extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = UserLog::all()->pluck('usr_id')->toArray();
        $numbers = Number::all()->pluck('num_id')->toArray();

        $begin = new \DateTime('2019-08-01');
        $end   = new \DateTime('2019-08-10');

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            for ($j = 0; $j < 1000; $j++) {
                $logs[] = [
                    'usr_id' => array_random($users),
                    'num_id' => array_random($numbers),
                    'log_message' => $faker->text(50),
                    'log_success' => array_random(['0', '1']),
                    'log_created' => $i->format("Y-m-d").' '.$faker->time()
                ];
            }
        }

        LogGlobal::insert($logs);
    }
}

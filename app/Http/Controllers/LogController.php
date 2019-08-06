<?php namespace App\Http\Controllers;

use App\{ LogAggregate, LogGlobal, Number, UserLog };
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Faker\Generator as Faker;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogController extends Controller
{
    /**
     * @param Request $request
     * @param Faker $faker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    function index(Request $request, Faker $faker)
    {
        if (!request()->ajax()) {
            return view('log');
        }

        if (!empty($request->from_date) && !empty($request->to_date)) {

            if ($request->action == 'generate') {
                $this->generate($request, $faker);
            }

            if ($request->action == 'aggregate') {
                $this->aggregate($request);
            }
        }

        $data = LogGlobal::all();
        return datatables()->of($data)->make(true);
    }

    /**
     * Generate dummy data for 'send_log' table
     *
     * @param Request $request
     * @param Faker $faker
     * @throws \Exception
     */
    protected function generate(Request $request, Faker $faker)
    {
        $users = UserLog::all()->pluck('usr_id')->toArray();
        $numbers = Number::all()->pluck('num_id')->toArray();

        $begin = new \DateTime($request->from_date);
        $end   = new \DateTime($request->to_date);

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            for ($j = 0; $j < $request->records; $j++) {
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

    /**
     * Select from 'send_log' table and push to 'send_log_aggregated'
     *
     * @param Request $request
     */
    protected function aggregate(Request $request)
    {
        DB::beginTransaction();
        try {
            $query = LogGlobal::select('send_log.usr_id', 'numbers.cnt_id', 'send_log.log_success', 'send_log.log_created')
                ->leftJoin('numbers', 'send_log.num_id', '=', 'numbers.num_id')
                ->whereDate('send_log.log_created', '>=', $request->from_date)
                ->whereDate('send_log.log_created', '<=', $request->to_date);

            LogAggregate::insertUsing(['usr_id', 'cnt_id', 'agg_success', 'agg_date'], $query);

            // Delete selected data
            LogGlobal::whereDate('send_log.log_created', '>=', $request->from_date)
                ->whereDate('send_log.log_created', '<=', $request->to_date)
                ->delete();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
        }
    }
}

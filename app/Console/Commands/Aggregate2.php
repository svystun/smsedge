<?php namespace App\Console\Commands;

use App\LogGlobal;
use App\LogAggregate2;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class Aggregate
 * @package App\Console\Commands
 */
class Aggregate2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aggregate:data2 {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate data and save';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date');

        $query = LogGlobal::selectRaw("DATE(send_log.log_created) as agg_date, numbers.cnt_id, 
            SUM(log_success = '1') as cnt_success, SUM(log_success = '0') as cnt_failed")
            ->leftJoin('numbers', 'send_log.num_id', '=', 'numbers.num_id');
        if ($date) {
            $query->where(DB::raw('DATE(log_created)'), $date);
        }
        $cnt = $query->groupby('agg_date', 'numbers.cnt_id')->orderby('agg_date')->get()->toArray();

        $query = LogGlobal::selectRaw("DATE(send_log.log_created) as agg_date, send_log.usr_id,
        SUM(log_success = '1') as usr_success, SUM(log_success = '0') as usr_failed")
            ->leftJoin('numbers', 'send_log.num_id', '=', 'numbers.num_id');
        if ($date) {
            $query->where(DB::raw('DATE(log_created)'), $date);
        }
        $usr = $query->groupby('agg_date', 'send_log.usr_id')->orderby('agg_date')->get()->toArray();

        $data = [];
        $max = max(count($cnt), count($usr));
        for ($i = 0; $i < $max; $i++) {
            $data[] = [
                'agg_date' => $date,
                'cnt_id' => isset($cnt[$i]['cnt_id']) ? $cnt[$i]['cnt_id'] : 0,
                'cnt_success' => isset($cnt[$i]['cnt_success']) ? $cnt[$i]['cnt_success'] : 0,
                'cnt_failed' => isset($cnt[$i]['cnt_failed']) ? $cnt[$i]['cnt_failed'] : 0,
                'usr_id' => isset($usr[$i]['usr_id']) ? $usr[$i]['usr_id'] : 0,
                'usr_success' => isset($usr[$i]['usr_success']) ? $usr[$i]['usr_success'] : 0,
                'usr_failed' => isset($usr[$i]['usr_failed']) ? $usr[$i]['usr_failed'] : 0
            ];
        }

        DB::beginTransaction();
        try {
            LogAggregate2::insert($data);
            // Delete selected data
//            if ($date) {
//                LogGlobal::whereDate('log_created', $date)->delete();
//            } else {
//                LogGlobal::delete();
//            }
            DB::commit();
            $message = "Data was successfully imported! For: ".$date."\n";
        } catch(\Exception $e) {
            DB::rollback();
            $message = "We have errors during import data!\n";
        }
        echo $message;
    }
}

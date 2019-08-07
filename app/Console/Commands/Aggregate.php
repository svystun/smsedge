<?php namespace App\Console\Commands;

use App\LogAggregate;
use App\LogGlobal;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class Aggregate
 * @package App\Console\Commands
 */
class Aggregate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aggregate:data {date?}';

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
        $date = $this->argument('date') ?: date('Y-m-d');

        DB::beginTransaction();
        try {
            $query = LogGlobal::selectRaw("DATE(log_created) as agg_date, numbers.cnt_id, send_log.usr_id, 
                SUM(log_success = '1') as success, SUM(log_success = '0') as failed")
                ->leftJoin('numbers', 'send_log.num_id', '=', 'numbers.num_id');
//            if ($date) {
//                $query->where(DB::raw('DATE(log_created)'), $date);
//            }
            $query->groupby('agg_date', 'numbers.cnt_id', 'send_log.usr_id')->orderby('agg_date')->orderby('numbers.cnt_id');
            LogAggregate::insertUsing(['agg_date', 'cnt_id', 'usr_id', 'success', 'failed'], $query);

            // Delete selected data
            if ($date) {
                LogGlobal::whereDate('log_created', $date)->delete();
            } else {
                LogGlobal::delete();
            }

            DB::commit();
            $message = "Data was successfully imported! For: ".$date."\n";
        } catch(\Exception $e) {
            DB::rollback();
            $message = "We have errors during import data!\n";
        }

        echo $message;
    }
}

<?php namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogAggregate2
 * @package App
 */
class LogAggregate2 extends Model
{
    protected $table = 'send_log_aggregated2';
    protected $fillable = ['agg_date', 'cnt_id', 'cnt_success', 'cnt_failed', 'usr_id', 'usr_success', 'usr_failed'];

    /**
     * @param $query
     * @param Request $request
     * @return mixed
     */
    function scopeGetData($query, Request $request)
    {
        $pre = '';
        if (!empty($request->country_id)) {
            $pre = 'cnt';
        }

        if (!empty($request->user_id)) {
            $pre = 'usr';
        }

        $query->select('agg_date', DB::raw($pre.'_success as success'), DB::raw($pre.'_failed as failed'));

        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereDate('agg_date', '>=', $request->from_date)
                ->whereDate('agg_date', '<=', $request->to_date);
        }

        if (!empty($request->country_id)) {
            $query->where('cnt_id', $request->country_id);
        }

        if (!empty($request->user_id)) {
            $query->where('usr_id', $request->user_id);
        }
        return $query;
    }
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogAggregate extends Model
{
    protected $table = 'send_log_aggregated';
    protected $fillable = ['agg_date', 'cnt_id', 'usr_id', 'success', 'failed'];

    /**
     * @param $query
     * @param Request $request
     * @return mixed
     */
    function scopeGetData($query, Request $request)
    {
        $query->select('agg_date', DB::raw('SUM(success) as success'), DB::raw('SUM(failed) as failed'));
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
        return $query->groupBy('agg_date');
    }
}

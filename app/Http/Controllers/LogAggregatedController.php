<?php namespace App\Http\Controllers;

use App\{ Country, User };
use Illuminate\Http\Request;
use App\LogAggregate;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogAggregatedController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    function index(Request $request)
    {
        if (request()->ajax()) {
            $data = LogAggregate::getData($request)->get();

            return datatables()->of($data)->make(true);
        }

        $users = User::where('usr_active', 1)->get();
        $countries = Country::all();

        return view('log-aggregated', compact('users', 'countries'));
    }
}

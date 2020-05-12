<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\OurProtocol;
use App\SocialWork;

class StatisticsController extends Controller
{
    //

    public function index() {
        $social_works = SocialWork::all();

    	return view('administrators/statistics/index')
        ->with('social_works', $social_works);
    }

    public function annual_collection_social_work(Request $request) {

        $social_works = SocialWork::all();
        $social_work = $request->social_work;
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

    	$anual_report = OurProtocol::select('social_works.id', 'social_works.name', DB::raw('SUM(practices.amount) as total_amount'), DB::raw("DATE_FORMAT(protocols.completion_date,'%M %Y') as month"))
    	->protocol()
    	->plan()
    	->social_work()
    	->practices()
        ->where('social_works.id', $social_work)
        ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
    	->groupBy('social_works.id', 'social_works.name', 'protocols.completion_date')
    	->get();

    	return view('administrators/statistics/annual_collection_social_work')
        ->with('social_works', $social_works)
        ->with('social_work', $social_work)
        ->with('initial_date', $initial_date)
        ->with('ended_date', $ended_date)
        ->with('data', $anual_report);

    }
}

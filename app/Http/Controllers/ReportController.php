<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Determination;
use App\Report;

class ReportController extends Controller
{

    private const RETRIES = 5;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //

        $determination = Determination::findOrFail($id);

        return view('determinations/reports/create')
        ->with('determination', $determination);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $report = Report::insertGetId([
            'name' => $request->name,
            'report' => $request->report,
            'determination_id' => $request->determination_id,
        ]);

        return redirect()->action('ReportController@show', [$report]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $report = Report::findOrFail($id);
        $determination = $report->determination;

        return view('determinations/reports/show')
        ->with('report', $report)
        ->with('determination', $determination);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $report = Report::findOrFail($id);
        $determination = $report->determination;

        return view('determinations/reports/edit')
        ->with('report', $report)
        ->with('determination', $determination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        DB::transaction(function () use ($request, $id) {

           $report = Report::where('id', '=', $id)
           ->update(
               [
                'name' => $request->name,
                'report' => $request->report, 
            ]);

       }, self::RETRIES);


        return redirect()->action('ReportController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
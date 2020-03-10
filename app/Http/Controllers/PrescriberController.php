<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Prescriber;

class PrescriberController extends Controller
{

	use Pagination;

	private const PER_PAGE = 15;
	private const ADJACENTS = 4;

	private const RETRIES = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	return view('prescribers/prescribers');
    }

    /**
    * Load prescribers
    * @param   \Illuminate\Http\Request  $request
    * @return View $view
    */
    public function load(Request $request) {

        // Request
    	$filter = $request['filter'];
    	$page = $request['page'];

    	$offset = ($page - 1) * self::PER_PAGE;
    	$query = Prescriber::index($filter, $offset, self::PER_PAGE);

        // Pagination
    	$count_rows = Prescriber::count_index($filter);
    	$total_pages = ceil($count_rows / self::PER_PAGE);

    	$paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

    	$view = view('prescribers/index')
    	->with('request', $request->all())
    	->with('prescribers', $query)
    	->with('paginate', $paginate);

    	return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    	return view('prescribers/create');
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
    	$id = DB::transaction(function () use ($request) {

            // data for prescribers
    		$full_name = $request['full_name'];
    		$phone = $request['phone'];
    		$email = $request['email'];
    		$provincial_enrollment = $request['provincial_enrollment'];
    		$national_enrollment = $request['national_enrollment'];

    		$prescriber = Prescriber::insertGetId([
    			'full_name' => $full_name,
    			'phone' => $phone,
    			'email' => $email,
    			'provincial_enrollment' => $provincial_enrollment,
    			'national_enrollment' => $national_enrollment,
    		]);

    		return $prescriber;
    	}, self::RETRIES);


    	return redirect()->action('PrescriberController@show', ['id' => $id]);
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
    	$prescriber = Prescriber::find($id);

    	$data = [
    		'id' => $prescriber->id,
    		'full_name' => $prescriber->full_name,
    		'phone' => $prescriber->phone,
    		'email' => $prescriber->email,
    		'provincial_enrollment' => $prescriber->provincial_enrollment,
    		'national_enrollment' => $prescriber->national_enrollment,
    	];


    	return view('prescribers/show')->with('prescriber', $data);
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
        $prescriber = Prescriber::find($id);

        $data = [
            'id' => $prescriber->id,
            'full_name' => $prescriber->full_name,
            'phone' => $prescriber->home_address,
            'email' => $prescriber->city,
            'provincial_enrollment' => $prescriber->provincial_enrollment,
            'national_enrollment' => $prescriber->national_enrollment,
        ];
        

        return view('prescribers/edit')->with('prescriber', $data);
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


         Prescriber::where('id', '=', $id)
         ->update(
             [
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'provincial_enrollment' => $request->provincial_enrollment,
                'national_enrollment' => $request->national_enrollment,
            ]);

        }, self::RETRIES);


        return redirect()->action('PrescriberController@show', ['id' => $id]);
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

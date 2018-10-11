<?php namespace App\Http\Controllers\System;

use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Http\Requests;
use App\Http\Requests\WorkWeekForm;
use App\Http\Controllers\Controller;
use App\Model\System\WorkWeek;
use Illuminate\Http\Request;

class WorkweekController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$breadcrumb = new Breadcrumb;
	
		$theme = new Theme;
		$breadcrumb->add('Dashboard',url('/'))->add('Work Week');
		$theme->addScript(url('public/js/controller/workweek-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = "Specify Work Week";
		$viewModel['breadcrumb'] = $breadcrumb->output();

		return view('system.workweek',$viewModel);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Get all as json
	 * @return Json
	 */
	public function getAll()
	{
		return json_encode(WorkWeek::getDays());	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$days = $req->all();
		if(count($days))
		{
			
			foreach($days as $day=>$status)
			{
				$status = trim($status);
				if(!empty($status)){
					$workWeek = WorkWeek::firstOrNew(array('day_name'=>$day));
					$workWeek->status = $status;
					$workWeek->save();
				}
			}	
		
		}
		return json_encode(array('message'=>array('Organization Information updated successfully')));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

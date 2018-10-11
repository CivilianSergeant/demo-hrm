<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\Model\Holiday;

use Illuminate\Http\Request;

class HolidayController extends Controller {

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
		$theme = new Theme;
		$breadcrumb = new Breadcrumb;
		$breadcrumb->add('Dashboard',url('/'))
					->add('Holiday');
		$theme->addScript(url('public/js/controller/holiday-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = "Holiday List";
		return view('system.holiday',$viewModel);
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
	
	public function getAll($date=null)
	{
		$date = (empty($date))? date('Y') : $date;
		return Holiday::where('holiday_date','like',$date.'%')->where('recurring','=',1,'or')->orderBy('holiday_date','asc')->get()->toJson();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		if($req->get('id'))
		{
			$holiday = Holiday::find($req->get('id'));
		
			$holiday->holiday_date = $req->get('holiday_date');
		}
		else
			$holiday = Holiday::firstOrNew(array('holiday_date'=>$req->get('holiday_date')));
		
		$holiday->name = $req->get('name');
		$holiday->recurring = (int)$req->get('recurring');
		$holiday->save();
		return array('message'=>array('Holiday Saved Successfully'));
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

	public function delete(Request $req)
	{
		$holiday = Holiday::find($req->get('id'));
		$holiday->delete();
		return array('message' => array('Holiday deleted successfully'));
	}
}

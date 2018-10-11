<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\System\WorkShift;
use Illuminate\Http\Request;
use App\Http\Requests\WorkShiftFrm;

class WorkshiftController extends Controller {


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
		$theme->addScript(url('public/js/controller/workshift-controller.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Work Shift');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title']='Work Shift';
		return view('system.workshift',$viewModel);
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
	 * Get All WorkShifts
	 */
	 public function getAll()
	 {
	 	return WorkShift::all()->toJson();
	 }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(WorkShiftFrm $req)
	{
		if(!count($req->messages())){
			$workShift = WorkShift::firstOrNew(array('shift_name'=>$req->get('shift_name')));
			$workShift->start_time = $req->get('start_time');
			$workShift->end_time = $req->get('end_time');
			$workShift->save();
			return array('message'=>array('Work Shift saved successfully'));
		}else{
			return $req->messages();
		}
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
	
	public function remove(Request $req)
	{
		$workShift = WorkShift::find($req->get('id'));
		if(count($workShift))
			$workShift->delete();
	}

}

<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\Model\System\Option;
use Illuminate\Http\Request;

class SettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/common.js'))
			  ->addScript(url('public/js/controller/settings.js'));
		
		$breadcrumb = new Breadcrumb;
		$breadcrumb->add('Dashboard',url('/'))->add('Application Settings');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = 'Application Settings';
		return view('system.settings',$viewModel);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}
	
	public function getSettings()
	{
		$attendance = Option::where('type','attendance')->get();
		$leave = Option::where('type','leave')->get();
		foreach($leave as $i=> $l)
		{
			if($l->key == "leave_type")
				$leave[$i]['value'] = implode(",",(json_decode($l->value)));
		}
		return array('attendance'=>$attendance,'leave'=>$leave);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	
	public function saveAttendanceSettings(Request $req)
	{
		$keyPair = $req->get('attendance');
		if(count($keyPair))
		{
			foreach($keyPair as $key =>$value)
			{
				$option = Option::firstOrNew(array('key'=>$key));
				$option->key = $key;
				$option->value = $value;
				$option->type = 'attendance';
				$option->save();
			}
		}
		
		
	}
	
	public function saveLeaveSettings(Request $req)
	{
		$keyPair = $req->get('leave');
		if(count($keyPair))
		{
			foreach($keyPair as $key =>$value)
			{
				$option = Option::firstOrNew(array('key'=>$key));
				$option->key = $key;
				if($key == "leave_type")
				{
					$value = explode(",",$value);
				}
				$option->value = (is_array($value))?json_encode($value) : $value;
				$option->type = 'leave';
				$option->save();
			}
		}
	}

}

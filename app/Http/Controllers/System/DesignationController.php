<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\System\Designation;
use App\Model\System\Department;
use App\Http\Requests\DesignationForm;

use Illuminate\Http\Request;

class DesignationController extends Controller {

	
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
		$breadcrumb->add('Dashboard',url('/'))->add('Designation');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$theme->addScript(url('public/js/controller/designation.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Designation';
		return view('system.designation',$viewModel);
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

	public function getAll()
	{
		return	Designation::with('Department')->get()->toJson();
	}
	
	public function getAllWithChild()
	{
		return	Designation::with('ChildDesignation','ChildDesignation.ChildDesignation','Department')->where('order',0)->get()->toJson();
	}
	
	public function getByDepartment($department_id)
	{
		return Designation::where('department_id',$department_id)->get()->toJson();		
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(DesignationForm $req)
	{
		if(!count($req->messages()))
		{
	       
	       $departmentID = $req->get('parent_department');
	       $designationID = $req->get('parent_designation');
	       $department  = Department::find($departmentID[0]);
	       $designation = Designation::firstOrNew(array(
	       	
	       		'description' => $req->get('description'),
	       		'quota'  => $req->get('quota'),
	       		'order'  => (!empty($designationID))? $designationID[0] : 0
	       		
	       	));
	       	$designation->title = $req->get('title');
			$department->Designation()->save($designation);
			return json_encode(array('message'=>array('Designation added successfully')));
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
	public function update(Request $req)
	{
		$designation =	Designation::find($req->get('id'));
		$designation->title = $req->get('title');
		$designation->description = $req->get('description');
		$designation->quota = $req->get('quota');
		$departmentID = $req->get('parent_department');
		$designationID = $req->get('parent_designation');
        $designation->department_id = $departmentID[0];
        $designation->order = (!empty($designationID))? $designationID[0] : 0;
        $designation->save();
        
        return json_encode(array('message'=>array('Designation Information updated successfully')));
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
		$designation = Designation::find($req->get('id'));
		$designation->delete();
	}
	
	

}

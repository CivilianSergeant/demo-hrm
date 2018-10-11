<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Http\Requests\Department\DepartmentForm;
use App\Http\Requests\Department\DepartmentUpdateForm;
use App\Model\System\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller {

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
		
		$breadcrumb->add('Dashboard',url('/'))->add('Department');
		$theme->addScript(url('public/js/controller/department-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = "Department";
		return view('system.department.department',$viewModel);
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
	 * Get all department as json
	 * @return Json;
	 */
	 
	public function getAll()
	{
		return Department::with('ChildDepartment','ChildDepartment.ChildDepartment','ChildDepartment.ChildDepartment.ChildDepartment')->where('parent_department',0)->get()->toJson();
	}
	
	public function getActiveDepartments()
	{
		return Department::all()->toJson();
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(DepartmentForm $req)
	{
		if(!count($req->messages()))
		{
			
			$parentDepartment = $req->get('parent_department');
			if(!empty($parentDepartment))
			{
				
				foreach($parentDepartment as $pd)
				{
					$department = Department::firstOrNew(array('name'=>$req->get('name')));
					$department->parent_department = $pd;
					$department->save();
				}
				
			}else{
				
				$department = Department::firstOrNew(array('name'=>$req->get('name')));
				$department->parent_department = 0;
				$department->save();
			}
			
			return json_encode(array('message'=>array('Organization Information updated successfully')));
		}
		else
		{
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
	public function update(DepartmentUpdateForm $req)
	{
		if($req->get('id'))
		{
			if(!strlen($req->get('name')))
			{
				return $req->messages();
			}
			
			$parentDepartment = $req->get('parent_department');
			if(!empty($parentDepartment))
			{
				
				foreach($parentDepartment as $pd)
				{
					$department = Department::find($req->get('id'));
					$department->name = $req->get('name');
					$department->parent_department = $pd;
					$department->save();
					
				}
				
			}else{
				
				$department = Department::find($req->get('id'));
				$department->name = $req->get('name');
				$department->parent_department = 0;
				$department->save();
			}
			return json_encode(array('message'=>array('Department updated successfully')));
		}
		
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
	  	$id = $req->get('id');
	  	if($id)
	  	{
	  		$department = Department::find($id);
	  		$department->delete();
	  		return json_encode(array('message'=>array('Department deleted successfully')));
	  		
	  	}else{
	  		return redirect('/');
	  	}
	}
	
	public function trash()
	{
		
		
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		
		$breadcrumb->add('Dashboard',url('/'))->add('Department');
		$theme->addScript(url('public/js/controller/department-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = "Department";
		return view('system.department.trash',$viewModel);
	}
	
	public function getTrashItems()
	{
		return Department::onlyTrashed()->get()->toJson();
	}
	
	public function undo(Request $req)
	{
		$department = Department::withTrashed()->where('id',$req->get('id'))->first();
			
		
		$department->deleted_at = null;
		$department->save();
	}
	
	public function deletePermanent(Request $req)
	{
		$department = Department::withTrashed()->where('id',$req->get('id'))->first();
		$department->forceDelete();
	}

}

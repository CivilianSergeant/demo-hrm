<?php namespace App\Http\Controllers\System;

use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Http\Requests;
use App\Http\Requests\OrgForm;
use App\Http\Controllers\Controller;
use App\Model\System\HrmOrg;
use Illuminate\Http\Request;

class OrgController extends Controller {

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
		$breadcrumb->add('Dashboard',url('/'))->add('Organization');
		$theme->addScript(url('public/js/controller/org-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = "System Inforamtion";
		return view('system.org',$viewModel);
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
	 * Get Org Json data
	 * 
	 */
	public function getOrg()
	{
		$org = HrmOrg::orderBy('id','desc')->first();
		
		return (count($org))? $org->toJson() : (new HrmOrg())->toJson();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(OrgForm $req)
	{
		if(!count($req->messages()))
		{
			
			$hrmOrg = HrmOrg::firstOrNew(array('title'=>$req->get('title')));
			$hrmOrg->phone = $req->get('phone');
			$hrmOrg->fax = $req->get('fax');
			$hrmOrg->email = $req->get('email');
			$hrmOrg->address = $req->get('address');
			$hrmOrg->country = $req->get('country');
			$hrmOrg->city = $req->get('city');
			$hrmOrg->state = $req->get('state');
			$hrmOrg->postcode = $req->get('postcode');
			$hrmOrg->save();
			return json_encode(array('message'=>array('Organization Information updated successfully')));
			
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

}

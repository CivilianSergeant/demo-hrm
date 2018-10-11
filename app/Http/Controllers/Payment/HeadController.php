<?php namespace App\Http\Controllers\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Helpers;
use App\Model\Payment\Head;
use App\Model\Payment\Group;

class HeadController extends Controller {

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
		$breadcrumb->add('Dashboard',url('/'))->add('Payment Head');
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/payment-head-controller.js'));
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Payment Heads';
		return view('payment.head',$viewModel);
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
		return Head::with('ParentHead')->get()->toJson();
	}
	
	public function getAllParentHeads()
	{
		return Head::where('parent_head','==','')->get()->toJson();
	}
	
	public function getHeadByJobType($job_type)
	{
		return Head::where('job_type',$job_type)->orderBy('head_name','ASC')->get()->toJson();
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$head = Head::firstOrNew(array(
			'head_name'   => $req->get('head_name'),
			'parent_head' => $req->get('parent_head'),
			'head_type'   => $req->get('head_type'),
			'job_type'    => $req->get('job_type')
		));
		
		$head->save();
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
		$head = Head::find($req->get('id'));
		if(count($head))
			$head->delete();
	}

}

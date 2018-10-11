<?php namespace App\Http\Controllers\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\Model\Payment\Head;
use App\Model\Payment\Group;

class GroupController extends Controller {

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
		$breadcrumb->add('Dashboard',url('/'))->add('Payment Group');
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/payment-group-controller.js'));
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Payment Heads';
		return view('payment.group',$viewModel);
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
		return Group::all()->toJson();
	}

	public function getPaymentGroup($job_type)
	{
		return Group::where('job_type',$job_type)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$heads = $req->get('head');
		$amount = $req->get('template');
		
		if(count($heads) == count($amount))
		{
			$template = [];
			foreach($heads as $head)
			{
				$template[$head['id']]['id'] = $head['id'];
				$template[$head['id']]['head_name'] = $head['head_name'];
				$template[$head['id']]['head_type'] = $head['head_type'];
				$template[$head['id']]['amount']    = (!empty($amount[$head['id']]))? $amount[$head['id']] : '';
			}
			
			$group = Group::firstOrNew(array(
				'title' => $req->get('title'),	
				'job_type' => $req->get('job_type')
			));
			
			$group->template = json_encode($template);
			$group->save();
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
		$id = $req->get('id');
		$heads = $req->get('head');
		$amount = $req->get('template');
		
		$group = Group::find($id);
		$group->title = $req->get('title');
		$template = [];
		if(count($heads) == count($amount))
		{
			foreach($heads as $head)
			{
				$template[$head['id']]['id'] = $head['id'];
				$template[$head['id']]['head_name'] = $head['head_name'];
				$template[$head['id']]['head_type'] = $head['head_type'];
				$template[$head['id']]['amount']    = (!empty($amount[$head['id']]))? $amount[$head['id']] : '';
			}
			$group->template = json_encode($template);
			$group->save();
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
		$group = Group::find($req->get('id'));
		if(count($group))
			$group->delete();
	}

}

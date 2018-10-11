<?php namespace App\Http\Controllers\Leave;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\Leave\Leave;
use App\Model\JobDetails;
use Illuminate\Http\Request;

class LeaveController extends Controller {

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
		$theme->addScript(url('public/js/controller/leave-controller.js'))
		      ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Leave');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Leave';
		return view('leave.leave',$viewModel);
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
		$userId = Auth::user()->id;
		return Leave::with('Employee','LeaveVerifier','Department')->where('created_by',$userId)->get()->toJson();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$userId = Auth::user()->id;
		$leave = Leave::firstOrNew(array(
					'employee_id'=>$req->get('employee_id'),
					'department_id'=>$req->get('department'),
					'start_dt' => $req->get('start_dt'),
					'end_dt' => $req->get('end_dt')
					));
		$leave->leave_verifier_id = $req->get('leave_verifier_id');
		$leave->leave_type = $req->get('leave_type');
		$leave->leave_reason = $req->get('leave_reason');
		if(!$leave->exists)
			 $leave->leave_status = Leave::$PENDING;
		$startDt = date_create($req->get('start_dt'));
		$endDt = date_create($req->get('end_dt'));
		$diff=date_diff($startDt,$endDt);
		
		$leave->leave_count = $diff->d;
		
		$jobDetails = JobDetails::where('employee_id',$req->get('employee_id'))->where('active_job',1)->first();
		$approvedLeaves = Leave::where('employee_id',$req->get('employee_id'))->where('created_at','like',date('Y').'%')->where('leave_status',Leave::$APPROVED)->get();
		
		$approvedLeaveCount = 0;
		
		if(count($approvedLeaves))
		{
			foreach($approvedLeaves as $al)
			{
				$approvedLeaveCount += ($al->leave_count);
			}
		}
		
		$leave->extra_leave = ($approvedLeaveCount > $jobDetails->leave_count)? 1 : 0;
		$leave->created_by = $userId;
		$leave->save();
		
		return array('message'=>array('Leave request send successfully'));
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

<?php namespace App\Http\Controllers;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Model\Leave\Leave;
use App\Model\Employee\EmployeePerformance;
use App\Helpers\Utils;
use Auth;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		$breadcrumb->add('Dashboard');
		$theme->addScript(url('public/js/controller/dashboard-controller.js'));
		$viewModel['welcome'] = "Welcome To Dashboard";
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
	
    	$viewModel['leave_request'] = Leave::where('leave_status',Leave::$PENDING)->where('leave_verifier_id',Auth::user()->employee_id)->count();
		$viewModel['evaluation_request'] = EmployeePerformance::where('status',EmployeePerformance::$PENDING)->where('feedback_by',Auth::user()->employee_id)->count();
		return view('dashboard-general',$viewModel);
	}

}

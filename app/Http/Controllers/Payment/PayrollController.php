<?php namespace App\Http\Controllers\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\Model\Employee\Employee;
use App\Model\JobDetails;
use App\Model\System\HrmOrg;
use Illuminate\Http\Request;

use App\Libraries\Report\PayrollReport;

class PayrollController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$breadCumb = new Breadcrumb;
		
		$theme->addScript(url('public/js/controller/payroll.js'))
			->addScript(url('public/js/services/department.js'))
			->addScript(url('public/js/services/employee.js'));
		$breadCumb->add('Dashboard',url('/'))->add('Payroll');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadCumb->output();
		$viewModel['page_title'] = 'Payroll Mangement';
		return view('payment.payroll',$viewModel);
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
	public function show(Request $req)
	{
		$employee = Employee::find($req->get('employee'));
		$jobDetails = JobDetails::with('Employee','Department','Designation','PaymentGroup')
						->where('employee_id',$employee->id)
						->where('active_job',1)
						->first();
						
		$payrollReport = new PayrollReport("L"); 
		$org = HrmOrg::first();
		$payrollReport->AddPage();
        $payrollReport->SetAutoPageBreak(true, 0.0);
        $payrollReport->SetFont('Arial', 'B', 18);
        $payrollReport->reportAreaWidth = 276;
        $payrollReport->columnWidth = $payrollReport->reportAreaWidth/4;
        $payrollReport->height = 10;
        $payrollReport->Cell($payrollReport->reportAreaWidth,$payrollReport->height,$org->title,0,1,"C");
        $payrollReport->SetFont('Arial', '', 14);
        $payrollReport->Cell($payrollReport->reportAreaWidth,$payrollReport->height*2,$org->address,0,1,"C");
        $payrollReport->SetFont('Arial', '', 12);
        $payrollReport->Cell($payrollReport->reportAreaWidth,$payrollReport->height,"Salary Slip",0,1,"C");
        $payrollReport->setEmployeeInfo($jobDetails);
        
       
        $payrollReport->setPayRollInfo($jobDetails);
        $payrollReport->output();
        exit;
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

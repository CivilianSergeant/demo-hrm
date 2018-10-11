<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\Kpi\Kpi;
use App\Model\Kpi\KpiTemplate;
use App\Model\Employee\EmployeePerformance;
use Illuminate\Http\Request;

class PerformanceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/kpi-controller.js'));
		
		$breadcurmb = new Breadcrumb;
		$breadcurmb->add('Dashboard',url('/'))->add('Performance Key');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcurmb->output();
		return view('kpi.list',$viewModel);
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
		return Kpi::all();
	}
	
	public function getAllTemplates()
	{
		return KpiTemplate::all();
	}
	
	public function getTemplate($id)
	{
		$template =  KpiTemplate::find($id);
		$template->kpi_template = json_decode($template->kpi_template);
		return $template;
	}
	
	
	public function kpiTemplate()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/kpi-controller.js'));
		
		$breadcurmb = new Breadcrumb;
		$breadcurmb->add('Dashboard',url('/'))->add('Performance Key Template');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcurmb->output();
		$viewModel['page_title'] = 'KPI Template';
		return view('kpi.kpi-template',$viewModel);
	}
	
	public function saveQuestion(Request $req)
	{
		$kpi =	Kpi::firstOrNew(array('question'=>$req->get('question')));
		$kpi->save();
		return array('message'=>array('Question created successfully'));
	}
	
	public function kpiUpdate(Request $req)
	{
		$kpi = Kpi::find($req->get('id'));
		$kpi->question = $req->get('question');
		$kpi->save();
		
		return array('message'=>array('Question Updated Successfully'));
	}
	
	public function saveTemplate(Request $req)
	{
		$templates = $req->get('template');
		$kpiTemplate = KpiTemplate::firstOrNew(array('title'=>$req->get('title')));
		$kpiTemplate->kpi_template = json_encode($templates);
		$kpiTemplate->save();
		
		return array('message'=>array('Template created successfully'));
	}
	
	public function updateTemplate(Request $req)
	{
		$templates = $req->get('template');
		$kpiTemplate = KpiTemplate::find($req->get('id'));
		$kpiTemplate->title = $req->get('title');
		$kpiTemplate->kpi_template = json_encode($templates);
		$kpiTemplate->save();
		
		return array('message'=>array('Template updated successfully'));
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

	public function removeKpi(Request $req)
	{
		$kpi = Kpi::find($req->get('id'));
		$kpi->delete();
		return array('message'=>array('Question deleted successfully'));
	}
	
	public function evaluation()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/evaluation-controller.js'));
		
		$breadcurmb = new Breadcrumb;
		$breadcurmb->add('Dashboard',url('/'))->add('Evaluation Request');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcurmb->output();
		$viewModel['page_title'] = 'Send Evaluation Request';
		return view('kpi.evaluation',$viewModel);
	}
	
	public function getAllEvaluations()
	{
		return	EmployeePerformance::with('Employee','Department','FeedbackBy')->get()->toJson();
	}
	
	public function saveRequest(Request $req)
	{
		$feedbackby = $req->get('feedback_by');
		$department_id = $req->get('department_id');
		$employee_id = $req->get('employee_id');
		$template = $req->get('template');
		if(count($feedbackby))
		{
			foreach($feedbackby as $f){
				$empPerformance = 	EmployeePerformance::firstOrNew(array(
										'employee_id' => $employee_id,
										'department_id' => $department_id,
										'feedback_by' => $f,
										'template'	  => $template
									));
				$empPerformance->save();
					
			}
		}
	}
	
	public function getQuestions($id)
	{
		$kpiTemplate = KpiTemplate::find($id);
		$questions = json_decode($kpiTemplate->kpi_template);
	
		return	Kpi::whereIn('id',$questions)->get()->toJson();
	}
	
	public function saveReview(Request $req)
	{
		$empPerformance = EmployeePerformance::where('employee_id',$req->get('employee_id'))
							->where('feedback_by',$req->get('feedback_by'))
							->where('department_id',$req->get('department_id'))
							->where('status',EmployeePerformance::$PENDING)->first();
							
	
		$remark = 0;
		foreach($req->get('remark') as $r)
		{
			$remark += $r;
		}
		$empPerformance->rating = $remark;
		$empPerformance->status = EmployeePerformance::$REVIEWED;
		$empPerformance->save();
	}
}

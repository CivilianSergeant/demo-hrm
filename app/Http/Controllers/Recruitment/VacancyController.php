<?php namespace App\Http\Controllers\Recruitment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\JobDetails;
use App\Model\Recruitment\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/vacancy-controller.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Vacancy');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Vacancy management';
		return view('recruitment.vacancy',$viewModel);
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
		return Vacancy::with('Department','Designation','HiringManager')->get()->toJson();
	}

	public function getHiringManager($department)
	{
		return JobDetails::with('Employee')->where('department_id',$department)->where('verifier',1)
				->where('active_job',1)->get()->toJson();	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$vacancy = Vacancy::firstOrNew(array(
			'department_id' => $req->get('department'),
			'designation_id'=>$req->get('designation'),
			'hiring_manager_id'=>$req->get('hiring_manager'),
			'vacancy_name' => $req->get('title')
		));
		$vacancy->number_of_post = $req->get('position');
		$vacancy->vacancy_description = $req->get('description');
		$vacancy->publish_feed_web = (int)$req->get('publish');
		$vacancy->save();
		
		return array('message'=>array('Vacancy successfully saved'));
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
		$vacancy = Vacancy::find($req->get('id'));
		$vacancy->vacancy_name = $req->get('title');
		$vacancy->department_id = $req->get('department');
		$vacancy->designation_id = $req->get('designation');
		$vacancy->hiring_manager_id = $req->get('hiring_manager');
		$vacancy->number_of_post = $req->get('position');
		$vacancy->vacancy_description = $req->get('description');
		$vacancy->publish_feed_web   = (int)$req->get('publish');
		$vacancy->save();
		
		return array('message'=>array('Vacancy information updated'));
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
		$vacancy = Vacancy::find($req->get('id'));
		$vacancy->delete();
		return array('message'=>array('Vacancy deleted'));
	}

}

<?php namespace App\Http\Controllers\Recruitment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\Recruitment\Candidate;
use App\Model\Recruitment\CandidateVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CandidateController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/candidate-controller.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Candidate');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Candidate management';
		return view('recruitment.candidate',$viewModel);
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
		return Candidate::with('Vacancy','Vacancy.HiringManager')->get()->toJson();
	}
	
	public function getHistories($id)
	{
		return Candidate::find($id)->Histories;
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$validator = Validator::make($req->all(), [
			'vacancy'=>'required']);
			
		if($validator->fails())
			return $validator->messages();
			
		$candidate = Candidate::firstOrNew(array('email'=>$req->get('email'),'vacancy_id'=>$req->get('vacancy')));
	
		$candidate->name = $req->get('name');
		$candidate->phone = $req->get('phone');
		$candidate->keyword = $req->get('keyword');
		$candidate->description = $req->get('description');
		$candidate->vacancy_id = $req->get('vacancy');
		$candidate->application_source	 = $req->get('source');
		$candidate->referer_name = $req->get('referer');
		$candidate->application_dt = date("Y-m-d");
		$candidate->status = 'Applied';
		
		$candidate->save();
		$candidateVacancy = CandidateVacancy::firstOrNew(array(
			'candidate_id' => $candidate->id,
			'vacancy_id'   => $candidate->vacancy_id,
			'status'       => $candidate->status
		));
		
		$candidateVacancy->save();
		
		return array('message'=>array('Candidate saved successfully'));
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
		$candidate = Candidate::find($req->get('id'));
		
		$candidate->name = $req->get('name');
		$candidate->phone = $req->get('phone');
		$candidate->keyword = $req->get('keyword');
		$candidate->description = $req->get('description');
		$candidate->vacancy_id = $req->get('vacancy');
		$candidate->application_source	 = $req->get('source');
		$candidate->referer_name = $req->get('referer');
		
		$candidate->status = $req->get('status');
		$candidate->save();
		
		$candidateVacancy = CandidateVacancy::firstOrNew(array(
			'candidate_id' => $candidate->id,
			'vacancy_id'   => $candidate->vacancy_id,
			'status'       => $candidate->status
		));
		
		$candidateVacancy->save();
		
		return array('message'=>array('Candidate updated successfully'));
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
		$candidate = Candidate::find($req->get('id'));
		if(count($candidate))
			$candidate->delete();
			
		return array('message'=>array('Candidate removed'));
	}

}

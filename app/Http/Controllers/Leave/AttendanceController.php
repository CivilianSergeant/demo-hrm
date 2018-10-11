<?php namespace App\Http\Controllers\Leave;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;

use Illuminate\Http\Request;
use App\Model\Leave\Attendance;

class AttendanceController extends Controller {


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
		$theme->addScript(url('public/js/controller/attendance-controller.js'))
		      ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Attendance');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Attendance';
		return view('leave.attendance',$viewModel);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$excel =	\App::make('excel');
       	$excel->load('Hrm_Attendance.xls',function($reader){
       		Utils::debug($reader->toArray());
       	});        
	}


	public function getAll()
	{
		return Attendance::with('Employee','WorkShift')->get()->toJson();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		
		 $employee_id = $req->get('employee_id');
		 $attendance = Attendance::firstOrNew(array('employee_id'=>$employee_id,'date'=>$req->get('date')));
		 $shift = $req->get('shift');
		 
		 $shift_st = $shift['work_shift']['start_time'];
		 $shift_et = $shift['work_shift']['end_time'];
		 
		 $st = $req->get('start_time');
		 $et = $req->get('end_time');
		 
		 $st_diff = date('H:i:s',(($st - $shift_st)/1000));
		 $et_diff = date('H:i:s',(($et - $shift_et)/1000));
		 
		 $work_time = round(($et-$st)/1000);
		 $wh = ($work_time/3600);
		 
		 $wm = ($wh/60);
		 $wh = ($wh>0)? round($wh): '00';
		 $wT = (strlen($wh)<2)? '0'.$wh : $wh;
		 $wT .= ":";
		 $wT .= ($wm >= 1 && $wm < 60)? ((strlen($wm)<2)? '0'.$wm:$wm) : '00';
		 
		 
		 
		 $attendance->work_shift_id = $shift['work_shift_id'];
		 $attendance->in_time = $st;
		 $attendance->out_time = $et;
		 $attendance->start_after = $st_diff;
		 $attendance->end_before = $et_diff;
		 $attendance->working_time = $wT;
		 $attendance->date = $req->get('date');
		 $attendance->leave_id = null;
		 
		 $attendance->save();
		 
		 return array('message'=>array('Attendance Successfully saved'));
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
		$attendance = Attendance::find($req->get('id'));
		$shift = $req->get('shift');
		$attendance->work_shift_id = $shift['work_shift_id'];
		$attendance->in_time = $req->get('start_time');
		$attendance->out_time = $req->get('end_time');
		$attendance->date = $req->get('date');
		$attendance->leave_id = null;
		$attendance->save();
		
		return array('message'=>array('Attendance Successfully saved'));
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
	
	public function getMyAttendance($month='',$year='')
	{
		$user = Auth::user();
		$date = (!empty($year) && !empty($month)) ? $year.'-'.$month : date('Y-m');
		$result = Attendance::with('WorkShift')->where('employee_id',$user->employee_id)->where('date','like',$date.'%')->get();
		$attendance = [];
		foreach($result as $r)
		{
			$attendance[$r->date][$r->WorkShift->shift_name]['in'] = (($r->start_time)/1000);
			$attendance[$r->date][$r->WorkShift->shift_name]['out'] = (($r->end_time)/1000);
		}
		return $attendance;
		Utils::LastQuery();
	}
	
	public function import()
	{
		
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/attendance-controller.js'))
		      ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
		$breadcrumb->add('Dashboard',url('/'))->add('Attendance',url('attendance'))->add('Import Attendance');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Import Attendance';
		$viewModel['file_columns'] = [];
		return view('leave.import-attendance',$viewModel);
	}
	
	
	public function saveImportAttendance(Request $req)
	{
		$viewModel['file_columns'] = '';
		if($req->hasFile('attendance'))
		{
				$fileObj = $req->file('attendance');
				$ext = $fileObj->getClientOriginalExtension();
				$name = $fileObj->getClientOriginalName();
				$prefix = time();
				$path = 'data/xls/';
                $name = $name; // $prefix.'_'.$name;
                
                if(in_array($ext,array('xls','xlsx'))){
                    $fileObj->move($path,$name);
                }
                $attendance = new Attendance();
                $viewModel['system_columns'] = $attendance->getAllColumnsNames();
                
				
				$excel =	\App::make('excel');
				$result = '';
		       	$excel->load($path.$name,function($reader)use(&$result){
		       		
		       		$result = array_keys($reader->first()->toArray());
		       	});        
				$viewModel['file_columns'] = $result;
				$breadcrumb = new Breadcrumb;
				
				$breadcrumb->add('Dashboard',url('/'))->add('Attendance',url('attendance'))->add('Import Attendance');
				$viewModel['breadcrumb'] = $breadcrumb->output();
				$theme = new Theme;
				$theme->addScript(url('public/js/controller/attendance-controller.js'))
		      		->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  		->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
				$viewModel['scripts'] = $theme->getScripts();
				$viewModel['page_title'] = 'Import Attendance';
				$viewModel['system_col_filter'] = ['work_shift_id','employee_id','in_time','out_time','date'];
				return view('leave.import-attendance',$viewModel);
		}else{
			Utils::debug($req->all());
		}
		return redirect('attendance/import');
			
	}

}

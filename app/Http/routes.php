<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

// Org route
Route::get('org','System\OrgController@index');
Route::post('org/create','System\OrgController@store');
Route::get('api/org.json','System\OrgController@getOrg');

// Department route
Route::get('department','System\DepartmentController@index');
Route::post('department/create','System\DepartmentController@store');
Route::post('department/update','System\DepartmentController@update');
Route::post('department/remove','System\DepartmentController@remove');
Route::post('department/undo','System\DepartmentController@undo');
Route::post('department/delete-permanent','System\DepartmentController@deletePermanent');
Route::get('api/departments.json','System\DepartmentController@getAll');
Route::get('departments.json','System\DepartmentController@getActiveDepartments');
Route::get('department/trash','System\DepartmentController@trash');
Route::get('department-trash.json','System\DepartmentController@getTrashItems');

// Designation route
Route::get('designation','System\DesignationController@index');
Route::post('designation/create','System\DesignationController@store');
Route::post('designation/update','System\DesignationController@update');
Route::post('designation/remove','System\DesignationController@remove');
Route::get('api/designations.json','System\DesignationController@getAll');
Route::get('designations/{department_id}','System\DesignationController@getByDepartment');
Route::get('api/designations-with-child.json','System\DesignationController@getAllWithChild');

// WorkWeek route
Route::get('workweek','System\WorkweekController@index');
Route::post('workweek/create','System\WorkweekController@store');
Route::get('api/workweek.json','System\WorkweekController@getAll');

// User route
Route::get('users','User\UserController@index');
Route::post('user/create','User\UserController@store');
Route::post('user/update','User\UserController@update');
Route::post('user/remove','User\UserController@remove');
Route::get('api/users.json','User\UserController@getAll');
Route::get('changepass','User\UserController@changePass');

// Role route
Route::get('role','User\RoleController@index');
Route::any('role/create','User\RoleController@store');
Route::get('api/roles.json','User\RoleController@getAll');

// Permission route
Route::get('permissions/{id}', 'User\PermissionController@index');
Route::post('permission/create','User\PermissionController@store');
Route::get('api/permissions.json','User\PermissionController@getAll');
Route::get('api/{id}/permission_role.json','User\PermissionController@getAllPermissionRole');

// Employee route
Route::get('employee','Employee\EmployeeController@index');
Route::get('profile','Employee\EmployeeController@profile');
Route::get('get-profile','Employee\EmployeeController@getProfile');
Route::get('api/available-employees.json','Employee\EmployeeController@getAvailableEmployees');
Route::get('api/assigned-employees.json','Employee\EmployeeController@getAssignedEmployees');
Route::post('employee/create','Employee\EmployeeController@store');
Route::post('employee/update/{option}','Employee\EmployeeController@update');
Route::get('employee/department/{id}','Employee\EmployeeController@getEmployeeByDepartment');
Route::post('employee/assign-work-shift','Employee\EmployeeController@assignWorkShift');
Route::get('employee-workshifts/{month}/{year}','Employee\EmployeeController@getWorkShifts');
Route::post('employee/remove-work-shift','Employee\EmployeeController@removeWorkShift');
Route::get('employee/workshift/{employee_id}/{date?}','Employee\EmployeeController@getWorkShiftByEmployee');
Route::get('leave-requests','Employee\EmployeeController@leaveRequests');
Route::get('api/get-leave-requests','Employee\EmployeeController@getLeaveRequests');
Route::post('approve-leave-request','Employee\EmployeeController@approveLeaveRequest');
Route::post('reject-leave-request','Employee\EmployeeController@rejectLeaveRequest');
Route::get('leave-request/me','Employee\EmployeeController@myLeaveRequest');
Route::get('attendance/me','Employee\EmployeeController@myAttendance');
Route::get('evaluation-requests/me','Employee\EmployeeController@evaluationRequest');
Route::get('get-evaluation-requests','Employee\EmployeeController@getEvaluationRequests');
Route::get('get-work-history/{id}','Employee\EmployeeController@getWorkHistory');

Route::get('holiday','System\HolidayController@index');
Route::post('holiday/create','System\HolidayController@store');
Route::post('holiday/update/{id}/{option}','System\HolidayController@update');
Route::get('holidays.json','System\HolidayController@getAll');
Route::get('holidays/{date}','System\HolidayController@getAll');
Route::post('holiday/delete','System\HolidayController@delete');

Route::get('workshift','System\WorkshiftController@index');
Route::post('workshift/create','System\WorkshiftController@store');
Route::post('workshift/remove','System\WorkshiftController@remove');
Route::get('workshifts.json','System\WorkshiftController@getAll');
Route::get('roster','Employee\RosterController@index');
Route::get('get-template/{option}','Employee\RosterController@getTemplate');

Route::get('vacancy','Recruitment\VacancyController@index');
Route::post('vacancy/save-vacancy','Recruitment\VacancyController@store');
Route::get('api/get-hiring-manager/{department}','Recruitment\VacancyController@getHiringManager');
Route::get('vacanicies.json','Recruitment\VacancyController@getAll');
Route::post('vacancy/remove','Recruitment\VacancyController@remove');
Route::post('vacancy/update','Recruitment\VacancyController@update');

Route::get('candidate','Recruitment\CandidateController@index');
Route::post('candidate/save-candidate','Recruitment\CandidateController@store');
Route::get('candidates.json','Recruitment\CandidateController@getAll');
Route::post('candidate/remove','Recruitment\CandidateController@remove');
Route::post('candidate/update','Recruitment\CandidateController@update');
Route::get('candidate/histories/{id}','Recruitment\CandidateController@getHistories');
Route::post('candidate/remove','Recruitment\CandidateController@remove');

Route::get('head','Payment\HeadController@index');
Route::get('head/{job_type?}','Payment\HeadController@getHeadByJobType');
Route::post('head/save-head','Payment\HeadController@store');
Route::post('head/update','Payment\HeadController@update');
Route::post('head/remove','Payment\HeadController@remove');
Route::get('heads.json','Payment\HeadController@getAll');
Route::get('parent-heads.json','Payment\HeadController@getAllParentHeads');

Route::get('group','Payment\GroupController@index');
Route::post('group/save-group','Payment\GroupController@store');
Route::post('group/update','Payment\GroupController@update');
Route::get('groups.json','Payment\GroupController@getAll');
Route::post('group/remove','Payment\GroupController@remove');
Route::get('get-payment-group/{job_type}','Payment\GroupController@getPaymentGroup');

// Payroll
Route::get('payroll','Payment\PayrollController@index');
Route::post('payroll/save','Payment\PayrollController@store');
Route::post('payroll/view','Payment\PayrollController@show');

Route::get('attendance','Leave\AttendanceController@index');
Route::post('attendance/save-attendance','Leave\AttendanceController@store');
Route::post('attendance/save-import-attendance','Leave\AttendanceController@saveImportAttendance');
Route::post('attendance/update','Leave\AttendanceController@update');
Route::get('attendances.json','Leave\AttendanceController@getAll');
Route::get('get-my-attendance','Leave\AttendanceController@getMyAttendance');
Route::get('attendance/import','Leave\AttendanceController@import');
Route::get('leave','Leave\LeaveController@index');
Route::post('leave/save-leave','Leave\LeaveController@store');
Route::post('leave/update','Leave\LeaveController@update');
Route::get('leaves.json','Leave\LeaveController@getAll');

// Performance KPI
Route::get('kpi','PerformanceController@index');
Route::get('kpi-template','PerformanceController@kpiTemplate');
Route::get('kpi.json','PerformanceController@getAll');
Route::get('kpi-templates.json','PerformanceController@getAllTemplates');
Route::get('kpi-template/{id}','PerformanceController@getTemplate');
Route::post('kpi/save','PerformanceController@saveQuestion');
Route::post('kpi/save-template','PerformanceController@saveTemplate');
Route::post('kpi/update-template','PerformanceController@updateTemplate');
Route::post('kpi/update','PerformanceController@kpiUpdate');
Route::post('kpi/remove','PerformanceController@removeKpi');

// Performance Evaluation
Route::get('evaluation','PerformanceController@evaluation');
Route::get('evaluations.json','PerformanceController@getAllEvaluations');
Route::post('send-evaluation-request','PerformanceController@saveRequest');
Route::get('get-questions/{id}','PerformanceController@getQuestions');
Route::post('performance/save-review','PerformanceController@saveReview');
Route::get('test','Leave\AttendanceController@create');

Route::get('settings','System\SettingsController@index');
Route::get('get-settings','System\SettingsController@getSettings');
Route::post('settings/save-attendance','System\SettingsController@saveAttendanceSettings');
Route::post('settings/save-leave','System\SettingsController@saveLeaveSettings');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);

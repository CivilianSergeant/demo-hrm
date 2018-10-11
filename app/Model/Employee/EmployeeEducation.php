<?php namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model {

	protected $table = "employee_educations";

    protected $fillable = ['employee_id','institution_name'];
}

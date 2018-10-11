<?php namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model {

	protected $table="work_experiences";

    protected $fillable = ['employee_id','work_title'];

}

<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {

	use SoftDeletes;
	

	protected $table="departments";
	
	protected $fillable=['name','parent_department','department_order'];
	
	protected $dates = ['deleted_at'];
	
	public function ChildDepartment()
	{
	    return $this->hasMany('App\Model\System\Department','parent_department');
	}
	
	public function Designation()
	{
		return $this->hasMany('App\Model\System\Designation','department_id');
	}

}

<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model {

	protected $table="work_shifts";
	
	protected $fillable = ['shift_name'];

}

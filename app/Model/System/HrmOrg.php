<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;

class HrmOrg extends Model {

	protected $table ="hrm_org";
	
	protected $fillable = ['title','phone','fax','email','address','country','city','state','postcode'];

}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionRole extends Model {

    use SoftDeletes;
    
	protected $table = "permission_role";
	
	
	
	protected $dates = ['deleted_at'];

}

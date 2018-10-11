<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

	

    public function hasPermission($permission)
    {
        return $this->hasOne('App\PermissionRole','role_id','id')->where('permission_id',$permission->id)->count();
    }
}

<?php namespace App\Model\Leave;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model {

	protected $table = "leaves";
	
	protected $fillable = ['department_id','employee_id','leave_verifier_id','leave_type','leave_reason','start_dt','end_dt','leave_count','extra_leave','created_by'];

    public static $PENDING = 'Pending';
    public static $APPROVED = 'Approved';
    public static $REJECTED = 'Rejected';
    
    public function Department()
    {
        return $this->belongsTo('App\Model\System\Department','department_id');
    }
    
    public function Employee()
    {
        return $this->belongsTo('App\Model\Employee\Employee','employee_id');
    }
    
    public function LeaveVerifier()
    {
        return $this->belongsTo('App\Model\Employee\Employee','leave_verifier_id');
    }
    
    
}

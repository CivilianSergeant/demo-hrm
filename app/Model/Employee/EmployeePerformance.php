<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeePerformance extends Model{
    
    protected $table = 'employee_performance';
    
    protected $fillable = ['employee_id','feedback_by','department_id','rating','template'];
    
    public static $PENDING = 'Pending';
    public static $REVIEWED = 'Reviewed';
    
    
    public function Employee()
    {
        return $this->belongsTo('App\Model\Employee\Employee','employee_id');
    }
    
    public function FeedbackBy()
    {
        return $this->belongsTo('App\Model\Employee\Employee','feedback_by');
    }
    
    public function Department()
    {
        return $this->belongsTo('App\Model\System\Department','department_id');
    }
    
    public function Template()
    {
        return $this->belongsTo('App\Model\Kpi\KpiTemplate','template');
    }
    
    
}
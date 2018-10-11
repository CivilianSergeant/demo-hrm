<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;

class WorkWeek extends Model {

	protected $table = "hrm_work_week";
	
	protected $fillable = ['day_name','status'];

    public static function getDays()
    {
        $days = self::all();
        $result = array();
        foreach($days as $day)
        {
            $result[$day->day_name] = $day->status;
        }
        
        return $result;
    }
}

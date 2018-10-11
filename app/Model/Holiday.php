<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model {

	protected $table ="holidays";
	
	protected $fillable = ['name','holiday_date','recurring'];
	
	public function getHolidayDateAttribute()
	{
		return date('j F, Y',strtotime($this->attributes['holiday_date']));
	}
	


}

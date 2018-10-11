<?php namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;

class Head extends Model {

	protected $table = "payment_heads";
	
	protected $fillable = ['head_name','parent_head','job_type','head_type'];

	public function ParentHead()
	{
		return $this->belongsTo('App\Model\Payment\Head','parent_head','id');
	}

}

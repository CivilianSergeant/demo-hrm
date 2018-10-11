<?php
namespace App\Model\Kpi;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model{
    
    protected $table = "kpi";
    
    protected $fillable = ['question'];
    
    
}
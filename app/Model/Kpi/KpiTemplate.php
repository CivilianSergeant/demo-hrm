<?php
namespace App\Model\Kpi;

use Illuminate\Database\Eloquent\Model;

class KpiTemplate extends Model{
    
    protected $table = "kpi_template";
    
    protected $fillable = ['title','kpi_template'];
    
    
    
}
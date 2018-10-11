<?php
namespace App\Helpers;

class Breadcrumb {
    
    private $crumbs=[];
    
    public function add($name,$path=null)
    {
        
        $this->crumbs[] = array('name'=>$name,'route'=>$path);
        return $this;
        
    }
    
    public function get()
    {
        return $this->crumbs;
    }
    
    public function output()
    {
        $output = '';
        if(count($this->crumbs))
        {
            
            foreach($this->crumbs as $i=> $crumb)
            {
                if($crumb['route'] == null)
                    $output .= '<li><strong>'.$crumb['name'].'</strong></li>';
                else
                    $output .= '<li><a href="'.$crumb['route'].'">'.$crumb['name'].'</a></li>';
            
            }
            
        }else{
            $output .= '<li><a href="'.url('dashboard').'">Dashboard'.'</a></li>';
        }
        
        return $output;
    }
    
}
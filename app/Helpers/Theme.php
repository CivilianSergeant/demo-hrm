<?php
namespace App\Helpers;

class Theme{
    
    private $scripts = array();
    private $styles  = array();
    
    public function addScript($path)
    {
        $this->scripts[] = $path;
        return $this;
    }
    
    public function getScripts()
    {
        return $this->scripts;
    }
    
    public function addStyle($path)
    {
        $this->styles[] = $path;
        return $this;
    }
    
    public function getStyles()
    {
        return $this->styles;
    }
    
    
}
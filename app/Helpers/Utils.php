<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
class Utils{
    
    /**
     * Render last query
     * @param $print
     * @return mixed
     */
    public static function LastQuery($print=1)
    {
        
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        if($print)
            echo'<pre>'. print_r($last_query);
        else
            return $last_query;
    }
    
    public static function debug($data,$die=true,$msg='',$flag=false)
    {
        echo '<pre>';
        echo "<strong>$msg</strong>";
        
        if($flag)
        {
            var_dump($data);
        }else{
            print_r($data);
        }
        
        echo '</pre>';
        
        if($die)
            die();
    }
}
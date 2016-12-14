<?php

namespace App\Helpers;

class System
{

    /**
     * @return float
     */
    public static function getServerCpu(){
        $load = sys_getloadavg();
        return round($load[2]);
    }

    /**
     * @return string
     */
    public static function getServerMemory()
    {
        return round(memory_get_usage()/1048576,2).''.' MB';
    }

    /**
     * @param int $coreCount
     * @param int $interval
     * @return float
     */
    public static function getSystemLoad($coreCount = 2, $interval = 1)
    {
        $rs = sys_getloadavg();
        $interval = $interval >= 1 && 3 <= $interval ? $interval : 1;
        $load = $rs[$interval];
        return round(($load * 100) / $coreCount,2);
    }



}
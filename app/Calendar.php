<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = ['name','time_setting'];
    protected $table = 'calendar';


    public function getTimesOfDay($day,$row)
    {

        $times = unserialize($this->time_setting);

        $A_times = array();

        
        foreach($times as $time)
        {
            if($time['day']==$day)
                $A_times[] = $time;
        }

        if(empty($A_times[$row]))
            return false;

        $time = $A_times[$row]['hh'] . ':' . $A_times[$row]['mm'];

        return $time;
    }


    public function getMaxRow()
    {
        $times = unserialize($this->time_setting);
        $maxRow= array();

        for($i=0;$i<7;$i++)
        {
            $row=0;
            foreach($times as $key => $time)
            {
                if($time['day']==$i)
                {
                   $row++;
                }
            }
            $maxRow[]=$row;
        }

        return max($maxRow);
    }
}

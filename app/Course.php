<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reservation;

class Course extends Model
{
    protected $fillable = ['name','places_max','points'];
    protected $table 	= 'course';

    public static function checkDisponibility($datetime, $id)
    {
        $places_max = self::find($id)->places_max;

    	$disponibility = $places_max - count(Reservation::getReservation($datetime, $id));
        return $disponibility;
    }
}



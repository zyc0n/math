<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'time_reservation'];
    protected $table = 'reservation';

    public static function getReservation($datetime,$course)
    {
        $reservation = self::where('time_reservation','=',$datetime)
            ->where('course_id','=',$course)
            ->get();
        return $reservation;
    }
}



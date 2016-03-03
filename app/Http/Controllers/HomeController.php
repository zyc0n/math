<?php
namespace App\Http\Controllers;

//use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Calendar;
use App\Course;
use App\Reservation;
use App\User;

class HomeController extends Controller
{

    private $dt;
    private $week=0;
    private $current;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->dt = Carbon::now();
        $this->current = $this->dt;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $times = Calendar::first();

        //echo User::find(Reservation::getReservation('2016-02-29 16:00:00',1)->first()->user_id)->name;

        if($this->getWeekDays())
            return view('home')
                ->with('year',$this->current->formatLocalized('%Y'))
                ->with('month',$this->current->formatLocalized('%B'))
                ->with('days',$this->getWeekDays())
                ->with('times',$times)
                ->with('course',Course::first());

    }


    public function getWeekDays($weeks=0)
    {
        $A_week_days=[];
        $this->current = $this->dt->addWeeks($weeks);
        for ($i=0; $i < 7; $i++)
        {   $A_week_days[]= [$this->dt->startOfWeek()->addDays($i)->formatLocalized('%d'),$this->dt->startOfWeek()->addDays($i)->formatLocalized('%A')];

        }

        return $A_week_days;
    }


    public function next(Request $request)
    {
        if ($request->ajax()) {

            $weeks  = $request->input('weeks');
            $days   = $this->getWeekDays($weeks);
            $month  = $this->current->formatLocalized('%B');

            return response()->json([$month,$days]);




            //echo '<pre>';
            //print_r($this->getWeekDays($dd));


            //return view('home')->with('days', $this->getWeekDays($this->week));

            //exit;
        }

    }
}

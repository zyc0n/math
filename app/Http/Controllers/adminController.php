<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCalendarFormRequest;
use App\Calendar;

class adminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }






    public function create(CreateCalendarFormRequest $request)
    {
        //$times = $request->all();
        $times = $request->except('_token');
        $collection = collect($times['days']);
        $sorted = $collection->sortBy('hh');
        $sorted->values()->all();



        //$sorted = array_values($sorted['days']);

        
        /////
        $calendar = Calendar::first();



        //$calendar = new Calendar();
        $calendar->name='standard';
        $calendar->time_setting = serialize($sorted->toArray());
        if ($calendar->update()) {
            return redirect('home')->with('message', 'bella prova');
        }   
    } 

    public function index(Request $request)
    {
        /*if ($request->ajax())
        {
            $times = $request->input('times');
            $calendar = new Calendar();
            $calendar->name='standard';
            $calendar->time_setting = serialize($times);
            if ($calendar->save()) {
                return response()->json($times);
            }
        }*/

        $calendar = new Calendar();

        
        if($calendar->first())
        {
            $days = unserialize(Calendar::first()->time_setting);

            return view('calendar.index')->with('days',$days);
        }
        else
        {
            return view('calendar.index');
        }
        
    }


    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature;
use DB;
use Carbon\Carbon;

class TemperatureController extends Controller
{
    public function viewHome()
    {
        $all_temp_five = DB::table('temperature')
        ->select('created_at', 'temp_max', 'temp_min', 'id')
        ->orderBy('created_at', 'desc')
        ->whereBetween('created_at', [
            Carbon::parse('last monday') -> startOfDay(),
            Carbon::parse('next friday') -> endOfDay(),
        ])    
        ->get();        

        $all_max_temp = DB::table('temperature')
        ->select(DB::raw('temp_max'))          
        ->orderBy('created_at', 'desc') 
        ->whereBetween('created_at', [
            Carbon::parse('last monday') -> startOfDay(),
            Carbon::parse('next friday') -> endOfDay(),
        ])     
        ->get()
        ->toJson();

        $all_min_temp = DB::table('temperature')
        ->select(DB::raw('temp_min'))          
        ->orderBy('created_at', 'desc')  
        ->whereBetween('created_at', [
            Carbon::parse('last monday') -> startOfDay(),
            Carbon::parse('next friday') -> endOfDay(),
        ])    
        ->get()
        ->toJson();

        $all_date = DB::table('temperature')
        ->select(DB::raw('DATE_FORMAT(temperature.created_at, "%d-%b-%Y") as formatted_date'))          
        ->orderBy('created_at', 'desc')   
        ->whereBetween('created_at', [
            Carbon::parse('last monday') -> startOfDay(),
            Carbon::parse('next friday') -> endOfDay(),
        ])   
        ->get()
        ->toJson();

        $latest_temp = DB::table('temperature')
        ->select(DB::raw('DATE_FORMAT(temperature.created_at, "%d") as latest_date'))
        ->orderBy('created_at', 'desc') 
        ->take(1)
        ->get();

        $latest_temp_date = (int)$latest_temp[0]->latest_date;

        $info_date = getdate();
        $date_today =  $info_date['mday'];

        if($latest_temp_date === $date_today)
        {
            $temp_rec_fl = true;
        }
        else
        {
            $temp_rec_fl = false;
        }

        return view('temperature', ['all_temp_five' => $all_temp_five, 'all_max_temp' => $all_max_temp, 'all_date' => $all_date, 'all_min_temp' => $all_min_temp, 'temp_rec_fl' => $temp_rec_fl]);
    }

    public function save_temp(Request $request)
    {
        $max_temp = $request->txttempmax;
        $min_temp = $request->txttempmin;

        $validatedTemp = $request->validate([
            'txttempmax' => 'required|between:0,99.99|numeric',
            'txttempmin' => 'required|between:0,99.99|numeric',
        ]);

        $temperature = new Temperature;
        $temperature->temp_max = $max_temp;
        $temperature->temp_min = $min_temp;
        $temperature->save();

        return redirect('/')->with('temp-alert', 'Success');
    }

    public function delete_temp($id)
    {
        $temperature = Temperature::find($id);
        $temperature->delete();
        
        return redirect('/')->with('status', 'deleted-temp');
    }

    public function view_temp_past_init()
    {
        $all_max_temp = DB::table('temperature')
        ->select(DB::raw('temp_max'))          
        ->orderBy('created_at', 'asc')    
        ->get()
        ->toJson();

        $all_min_temp = DB::table('temperature')
        ->select(DB::raw('temp_min'))          
        ->orderBy('created_at', 'asc')    
        ->get()
        ->toJson();

        $all_date = DB::table('temperature')
        ->select(DB::raw('DATE_FORMAT(temperature.created_at, "%d-%b-%Y") as formatted_date'))          
        ->orderBy('created_at', 'asc')      
        ->get()
        ->toJson();

        return view('past_temperature', ['all_max_temp' => $all_max_temp, 'all_date' => $all_date, 'all_min_temp' => $all_min_temp]);
    }

    public function view_temp_past(Request $request)
    {
        $to_dur = $request->dto;
        $from_dur = $request->dfrom;

        $validatedTemp = $request->validate([
            'dto' => 'required',
            'dfrom' => 'required',
        ]);

        $all_max_temp = DB::table('temperature')
        ->select(DB::raw('temp_max'))          
        ->orderBy('created_at', 'asc') 
        ->whereBetween('created_at', [
            $from_dur, $to_dur
        ])     
        ->get()
        ->toJson();

        $all_min_temp = DB::table('temperature')
        ->select(DB::raw('temp_min'))          
        ->orderBy('created_at', 'asc')  
        ->whereBetween('created_at', [
            $from_dur, $to_dur
        ])    
        ->get()
        ->toJson();

        $all_date = DB::table('temperature')
        ->select(DB::raw('DATE_FORMAT(temperature.created_at, "%d-%b-%Y") as formatted_date'))          
        ->orderBy('created_at', 'asc')   
        ->whereBetween('created_at', [
           $from_dur, $to_dur 
        ])   
        ->get()
        ->toJson();

        return view('past_temperature', ['all_max_temp' => $all_max_temp, 'all_date' => $all_date, 'all_min_temp' => $all_min_temp]);
    }
}

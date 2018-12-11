<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature;
use DB;


class basicController extends Controller
{
    public function viewHome()
    {
        $all_temp_five = DB::table('temperature')
        ->select('created_at', 'temp_max', 'temp_min', 'id')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        $all_max_temp = DB::table('temperature')
        ->select(DB::raw('temp_max'))          
        ->orderBy('created_at', 'desc')      
        ->get()
        ->toJson();

        $all_min_temp = DB::table('temperature')
        ->select(DB::raw('temp_min'))          
        ->orderBy('created_at', 'desc')      
        ->get()
        ->toJson();

        $all_date = DB::table('temperature')
        ->select(DB::raw('DATE_FORMAT(temperature.created_at, "%d-%b-%Y") as formatted_date'))          
        ->orderBy('created_at', 'desc')      
        ->get()
        ->toJson();

        return view('temperature', ['all_temp_five' => $all_temp_five, 'all_max_temp' => $all_max_temp, 'all_date' => $all_date, 'all_min_temp' => $all_min_temp]);
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
}

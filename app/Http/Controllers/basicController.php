<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature;
use DB;
use Khill\Lavacharts\Lavacharts;

class basicController extends Controller
{
    public function viewHome()
    {
        $all_temp_five = DB::table('temperature')
        ->select('created_at', 'temp_max', 'temp_min')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        

        var_dump($all_temp_array);die;

        $lava_all_temp = new Lavacharts;
        $lava_popu = $lava_all_temp->DataTable();
        $lava_popu->addDateColumn('Date')
        ->addNumberColumn('Max Temp')
        ->addNumberColumn('Min Temp')
        ->addRows($all_temp_array);

        $lava_all_temp->LineChart('Temps', $lava_popu, [
            'title' => 'Home Temperature'
        ]);

        return view('temperature', ['all_temp' => $all_temp]);
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
}

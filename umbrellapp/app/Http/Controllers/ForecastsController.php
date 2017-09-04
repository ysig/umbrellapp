<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForecastsController extends Controller
{
	/* Return all forecasts */
	public function getAllForecasts(){
	    return \App\Forecast::all();
	}

	/* All forecasts for city,country */
	public function cityForecast($city, $country) {
	    $forecast = \App\Forecast::where('City', '=', $city)->where('Country', '=', $country)
					->orderBy('City')->orderBy('Country')->orderBy('Date','desc')->orderBy('Time','desc')->get();
		if($forecast <> null){
			return $forecast;
		}
		else{
			return response()->json(['Error' => 'No forecasts on city: ' . $city . ', country: ' . $country ],404);
		}
	    
	}

	/* All forecasts for a certain date (at a city, country) */
	public function dateCity($city, $country, $date){
	    $forecast = \App\Forecast::where('City', '=', $city)->where('Country', '=', $country)->where('Date','=',$date)
					->orderBy('City')->orderBy('Country')->orderBy('Date','desc')->orderBy('Time','desc')->get();
		if($forecast <> null){
			return $forecast;
		}
		else{
			return response()->json(['Error' => 'No forecasts on city: ' . $city . ', country: ' . $country . ', date: '. $date],404);
		}	
	}


	/* Add a new Forecast */
	public function addForecast(Request $request) {
	    return \App\Forecast::create($request->all());
	}

	/* Update a certain forecast based on [city, country, date, time] [null time also]*/
	public function updateForecast(Request $request, $city, $country, $date, $time) {
		$forecast = \App\Forecast::where('City', '=', $city)->where('Country', '=', $country)
					->whereDate('Date','=',$date)->whereTime('Time','=',$time)->take(1)->first();
		if($forecast <> null){
			$forecast->update($request->all());
			return $forecast;
		}
		else{
			return response()->json(['Error' => 'No forecasts on city: ' . $city . ', country: ' . $country . ', date: '. $date . ', time: '.$time],404);
		}
	    
	}

	/* Delete a certain forecast based on [city, country, date, time] [null time also] */
	public function deleteForecast($city, $country, $date, $time) {
		$forecast = \App\Forecast::where('City', '=', $city)->where('Country', '=', $country)->where('Date','=',$date)->where('Time','=',$time);
		if($forecast->get() <> null){
			$forecast->delete();
			return response()->json(null,204);
		}else{
			return response()->json(['Error' => 'No forecasts on city: ' . $city . ', country: ' . $country . ', date: '. $date . ', time: '.$time],404);
		}
	}
}



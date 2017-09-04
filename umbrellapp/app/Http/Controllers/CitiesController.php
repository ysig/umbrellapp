<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /* existential */
	public function exists($city,$country) {
    	$city = \App\Cities::where('City', '=', $city)->where('Country', '=', $country)->first();
		return ($city <> null) ? response()->json(null, 200) : response()->json(['Error' => 'The combination (' . $city . ',' . $country . ') does not exist.'], 404);
	}

	/* New cities support */
	public function addCity(Request $request){
		return \App\Cities::create($request->all()); 
	}

	/* No point for having an update function*/

	/* Delete in the case a city is now on not supported */
    public function deleteCity($city,$country) {
	    \App\Cities::where('City', '=', $city)->where('Country', '=', $country)->delete();
	    return response()->json(null, 204);
	}
}

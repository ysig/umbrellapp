<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
	/* Return all Favorites based on User Id */
    public function UsersFavorites($id) {
		$fav = \App\Favorites::where('User', '=', $id);
	    if($fav <> null){
			return response()->json($fav->get(),200);
		}else{
			return response()->json(['Error' => 'No Favorites for user: ' . $user ],404);
		}
	}

	/* Create new favorites */
	public function AddToFavorites(Request $request) {
		$agu = \App\Favorites::create($request->all());
		return $agu;
	}

	/* No meaning for having an update function*/

	/* Delete based on a combination of all three primary keys */
	public function deleteFavorite($id,$city,$country) {
		$fav = \App\Favorites::where('User', '=', $id)->where('City', '=', $city)->where('Country', '=', $country);
		if($fav <> null){
			$fav->delete();
			return response()->json(null,204);
		}else{
			return response()->json(['Error' => 'No Favorites for the combination: user: ' . $id . ', city: ' . $city . ', country: ' . $country . '.'],404);
		}
	    
	}

	public function deleteUserFavorites($id) {
	    $fav = \App\Favorites::where('User', '=', $id);
		if($fav <> null){
			$fav->delete();
			return response()->json(null,204);
		}else{
			return response()->json(['Error' => 'No Favorites for user: ' . $user],404);
		}
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Users;
class UsersController extends Controller
{
  	public function index()
   	{
   	    return Users::all();
   	}

   	public function show($id)
    {
        return Users::where('User Id', $id)->first();
    }

    public function store(Request $request)
    {
        return Users::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $user = Users::where('User Id', $id)->first();
		if($user <> null){
			$user->update($request->all());
			return $user;
		}
		else{
			return response()->json(['Error' => 'No user to update with id: ' . $id],404);
		}
	}

	public function delete(Request $request, $id)
	{
		$user = Users::where('User Id', $id)->first();

		if($user <> null){
			$user->delete();
			return response()->json(null,204);
		}else{
			return response()->json(['Error' => 'No user to delete with id: ' . $id],404);
		}
	   
	}
	

	public function show_by_name_email($name,$email)
    {
        $user = Users::where('name', $name)->where('e-mail',$email)->first();
		
		if($user <> null){
			return response()->json($user,200);
		}else{
			return response()->json(['Error' => 'No user with name: ' . $name . ', e-mail: ' . $email],404);
		}
		
    }
	

	public function delete_by_name_email($name,$email){
    	$user = Users::where('name', $name)->where('e-mail',$email)->first();
		if($user <> null){
			$user->delete();
			return response()->json(null,204);
		}else{
			return response()->json(['Error' => 'No user to delete with name: ' . $name . ', e-mail: ' . $email],404);
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Log;

class JwtAuthenticateController extends Controller
{
    public function index()
    {
        return response()->json(['auth'=>Auth::user(), 'users'=>User::all()]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if(!$validator->fails()){
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);

            $token = JWTAuth::fromUser($user);

             return response()->json(['token' => $token]);
        }
        
        return response()->json('failed',500);
    }

    public function createRole(Request $request){
    	$role = new Role;
    	$role->name = $request->name;
    	$role->save();

    	return response()->json("created");   
    }

    public function createPermission(Request $request){
        $permission = new Permission;
    	$permission->name = $request->name;
    	$permission->save();

    	return response()->json("created");      
    }

    public function assignRole(Request $request){
        $user = User::where('email',$request->email)->first();

        $role = Role::where('name',$request->role)->first();

        $user->roles()->attach($role->id);

        return response()->json("created");
    }

    public function attachPermission(Request $request){
    	$role = Role::where('name', $request->role)->first();
	    $permission = Permission::where('name', $request->name)->first();
	    
	    $role->attachPermission($permission);

	    return response()->json("created");    
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json($user);
    }

    
}

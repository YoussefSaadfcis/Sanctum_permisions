<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request){

        $user = User::where('phone',$request->phone)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                "message" => "User phone or password are Invalid",
            ], 401);
        };
        $token = $user->createToken('auth_token')->plainTextToken;
             return response()->json([
                "message" => "User authenticated successfully",
                'token' => $token,
                'user' => new UserResource($user),
            ], 200);
    }

}

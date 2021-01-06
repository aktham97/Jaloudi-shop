<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|string',
            'password'=>'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }


        if (!Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return response()->json([
                'massage'=>'Unauthorized',
                'status_code'=>401
            ],401);

        }
        $user = $request->user();

        if($user->role == 'administrator')
        {
            $tokenData = $user->createToken('Personal access Token',['do_anything']);
        }else
        {
            $tokenData = $user->createToken('Personal access Token',['can_create']);
        }




        $token = $tokenData->token;
        if ($request->remember_me)
        {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        if ($token->save())
        {
            return response()->json([
               'user'=>$user,
               'access_token'=>$tokenData->accessToken,
                'token_type'=>'Bearer',
                'token_scope'=>$tokenData->token->scopes[0],
                'expires_at'=>Carbon::parse($tokenData->token->expires_at)->toDateTimeLocalString(),
                'status_code'=>200
            ],200);
        }else
        {
            return response()->json([
               'massage' => 'some error occurred , please try again',
                'status_code'=>500
            ],500);
        }


    }
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }
      $user = User::query()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        if ($user)
        {
            return response()->json([
                'user' => $user,
                'message' => 'Success',
                'status_code'=>200
            ],200);

        }
        else
        {
            return response()->json([
                'message'=>'Some thing error , please try again!'
            ],500);
        }

    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
         return response()->json([
           'massage'=>'logout successfully',
            'status_code'=>200
        ],200);
    }
}

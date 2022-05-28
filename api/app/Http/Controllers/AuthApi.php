<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthApi extends Controller
{
    public function register(Request $request){
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);
        if($v->fails()){
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>$v->errors(),
            ]);
        }

        $file = $request->file("image");
        $image_name = uniqid() . $file->getClientOriginalName();
        $image_path = "/image/" . $image_name;
        $file->move(public_path('/image/'), $image_name);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'image'=>$image_path,
        ]);
        $token = $user->createToken("user")->accessToken;
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>["token"=>$token, 'user'=>$user]
        ]);
    }

    public function login(Request $request){
        $v = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($v->fails()){
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>$v->errors(),
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('user')->accessToken;
                return response()->json([
                    'success'=>true,
                    'status'=>200,
                    'data'=>[
                        'token' => $token,
                        'user' => $user,
                    ]
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'status'=>500,
                    'data'=>'wrong_password',
                ]);
            }
        }else{
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>'wrong_email',
            ]);
        }

    }
}

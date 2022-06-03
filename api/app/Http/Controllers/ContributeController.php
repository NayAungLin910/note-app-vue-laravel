<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ContributeController extends Controller
{
    public function findUser($email){
        $user = User::where('email', $email)->first();

        if($user){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'data'=>$user,
            ]);   
        }

        return response()->json([
            'success'=>false,
            'status'=>500,
            'data'=>'not_user',
        ]);    
    }
}

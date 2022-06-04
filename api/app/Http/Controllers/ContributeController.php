<?php

namespace App\Http\Controllers;

use App\Models\Contribute;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function contribute(Request $request){
        $contributor_id = $request->contributor_id;
        $contributed_id = $request->contributed_id;
        $note_slug = $request->slug;
        $note_id = Note::where('slug', $note_slug)->first()->id;

        Contribute::create([
            'contributor_id'=>Auth::guard('api')->user()->id,
            'contributed_id'=>$contributed_id,
            'note_id'=>$note_id,
        ]);
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>null,
        ]); 
    }
}

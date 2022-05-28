<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Label;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteApi extends Controller
{
    public function create(Request $request){
        $user_id = Auth::guard('api')->user()->id;
        $note = Note::create([
            'slug'=>uniqid() . Str::slug($request->name),
            'label_id'=>$request->label_id,
            'color_id'=>$request->color_id,
            'user_id'=>$user_id,
            'name'=>$request->name,
            'description'=>$request->description,
        ]);
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>$note,
        ]);
    }

    public function ColorLabel(){
        $color = Color::all();
        $label = Label::where("user_id", Auth::guard('api')->user()->id)->latest()->get(); 
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=>[
                'color'=>$color,
                'label'=>$label,
            ],
        ]);
    }
}

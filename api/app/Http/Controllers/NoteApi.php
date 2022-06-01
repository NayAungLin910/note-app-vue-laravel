<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Label;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NoteApi extends Controller
{
    public function update(Request $request, $slug){
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'label_id' => 'required',
            'color_id' => 'required',
        ]);
        if($v->fails()){
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>$v->errors(),
            ]);
        }

        $note = Note::where('slug', $slug);
        $note_id = $note->first()->id;
        $note->update([
            'name'=>$request->name,
            'label_id'=>$request->label_id,
            'color_id'=>$request->color_id,
            'description'=>$request->description,
            'slug'=>Str::slug(uniqid() . $request->name),
        ]);
        $note = Note::where('id', $note_id)->with('color', 'label', 'user')->first();
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=> $note,
        ]);    
    }

    public function detail($slug){
        $note = Note::where('slug', $slug)->with('color', 'label', 'user')->first();
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=> $note,
        ]);
    }

    public function noteByLabel($slug){
        $label_id = Label::where('slug', $slug)->first()->id;
        $note = Note::latest()->where('label_id', $label_id)->with('color')->paginate(6);
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=> $note,
        ]);
    }

    public function create(Request $request){
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'label_id' => 'required',
            'color_id' => 'required',
        ]);
        if($v->fails()){
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>$v->errors(),
            ]);
        }

        $user_id = Auth::guard('api')->user()->id;
        $note = Note::create([
            'slug'=>Str::slug(uniqid() . $request->name),
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
        $label = Label::where("user_id", Auth::guard('api')->user()->id)->withCount('note')->latest()->get(); 
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=>[
                'color'=>$color,
                'label'=>$label,
            ],
        ]);
    }

    public function all(){
        $note = Note::latest()->with('color')->paginate(6);
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=> $note,
        ]);
    }
}

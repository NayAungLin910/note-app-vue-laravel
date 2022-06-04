<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Contribute;
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
        $user_id = Auth::guard('api')->user()->id;
        $note = Note::latest()->where('label_id', $label_id)->where('user_id', $user_id)->with('color')->paginate(6);
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

    public function labelCreate(Request $request){
        $v = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($v->fails()){
            return response()->json([
                'success'=>false,
                'status'=>500,
                'data'=>$v->errors(),
            ]);
        }   
        $user_id = Auth::guard('api')->user()->id;
        $label = Label::create([
            'user_id'=>$user_id,
            'name'=>$request->name,
            'slug'=>Str::slug(uniqid() . $request->name),
        ]);
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>$label,
        ]);     
    }

    public function ColorLabel(){
        $color = Color::all();
        $label = Label::where("user_id", Auth::guard('api')->user()->id)->withCount('note')->latest()->get(); 
        $auth_user_id = Auth::guard('api')->user()->id;
        $share = Contribute::where('contributor_id', $auth_user_id)->with('share', 'receiver', 'note')->take(5)->get();
        $receive = Contribute::where('contributed_id', $auth_user_id)->with('share', 'receiver', 'note')->take(5)->get();
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=>[
                'color'=>$color,
                'label'=>$label, 
                'share_note'=>$share,
                'receive_note'=>$receive,
            ],
        ]);
    }

    public function all(){
        $user_id = Auth::guard('api')->user()->id;
        $note = Note::latest()->with('color')->where('user_id', $user_id)->paginate(6);
        return response()->json([
            'success'=>true,
            'status'=>200,  
            'data'=> $note,
        ]);
    }
}

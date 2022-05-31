<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'user_id',
        'color_id',
        'label_id',
        'name',
        'description',
    ];

    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function label(){
        return $this->belongsTo(Label::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'contributor_id',
        'contributed_id',
        'note_id',
    ];

    public function share(){
        return $this->belongsTo(User::class, 'contributor_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class, 'contributed_id');
    }
    public function note(){
        return $this->belongsTo(Note::class, 'note_id');
    }
}

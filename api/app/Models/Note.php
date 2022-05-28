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
}

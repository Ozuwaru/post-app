<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=
        [
            'text',
            'imgPath',
            'videoPath',
            'user_id'
        ];
    use HasFactory;
}

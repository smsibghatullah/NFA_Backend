<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForensicPost extends Model
{
    use HasFactory;
        protected $fillable = ['tab', 'title', 'img1', 'content'];

}

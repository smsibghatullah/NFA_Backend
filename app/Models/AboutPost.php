<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPost extends Model
{
    use HasFactory;
    // app/Models/AboutPost.php
protected $fillable = ['title','img1','img2','content'];

}

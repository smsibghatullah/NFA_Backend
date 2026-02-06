<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInfo extends Model
{
    use HasFactory;
     protected $fillable = [
        'email',
        'phone',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'is_visible'
    ];
}

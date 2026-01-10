<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Auth extends Authenticatable
{
    use Notifiable;

    protected $table = 'auth';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hide password in arrays
    protected $hidden = [
        'password',
    ];
}

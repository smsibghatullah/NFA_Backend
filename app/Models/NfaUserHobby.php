<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfaUserHobby extends Model
{
    use HasFactory;

    protected $table = 'nfa_user_hobbies';

    protected $fillable = [
        'name',
        'description'
    ];

    public function profile()
    {
        return $this->belongsTo(NfaUserProfile::class, 'profile_id', 'id');
    }
}

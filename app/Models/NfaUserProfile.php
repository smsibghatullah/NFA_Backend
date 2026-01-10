<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfaUserProfile extends Model
{
    use HasFactory;

    protected $table = 'nfa_user_profiles';

    protected $fillable = [
        'nfa_user_id',
        'date_of_birth',
        'postal_address',
        'phone_number',
        'bio',
    ];

    public function user()
{
    return $this->belongsTo(NfaUser::class, 'nfa_user_id', 'id');
}

    public function educations()
    {
        return $this->hasMany(NfaUserEducation::class, 'profile_id');
    }

    public function workHistories()
    {
        return $this->hasMany(NfaUserWorkHistory::class, 'profile_id');
    }
}

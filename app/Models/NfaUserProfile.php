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
        'father_name',
        'cnic',
        'gender',
        'marital_status',
        'date_of_birth',
        'phone_number',
        'permanent_address',
        'current_address',
        'postal_code',
        'domicile_city',
        'domicile_province',
        'religion',
        'nationality',
        'current_occupation',
        'profile_picture',
        'bio',
    ];

    /**
     * 🔹 Relations
     */

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

    public function skills()
    {
        return $this->hasMany(NfaUserSkill::class, 'profile_id');
    }

    public function hobbies()
    {
        return $this->hasMany(NfaUserHobby::class, 'profile_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfaUserEducation extends Model
{
    use HasFactory;

    protected $table = 'nfa_user_educations';

    protected $fillable = [
        'institution_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'grade',
        'description'
    ];

    public function profile()
    {
        return $this->belongsTo(NfaUserProfile::class, 'profile_id', 'id');
    }
}

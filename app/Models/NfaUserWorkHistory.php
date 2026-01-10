<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfaUserWorkHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id', 'company_name', 'job_title',
        'start_date', 'end_date', 'responsibilities', 'is_current'
    ];

public function profile()
{
    return $this->belongsTo(NfaUserProfile::class, 'profile_id', 'id');
}

}

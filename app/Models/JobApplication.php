<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'cv',
        'degree',
        'cnic',
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(NfaUser::class, 'user_id');
    }

    // Relation with Job
    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_title',
        'location', 
        'application_deadline',
        'number_of_positions',
        'salary_range',
        'required_education',
        'required_experience',
        'responsibilities',
        'additional_info',
    ];
}

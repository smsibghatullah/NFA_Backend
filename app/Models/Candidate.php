<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'sr_no','roll_no','name','father_name','cnic',
        'post_applied_for','postal_address','mobile_no',
        'paper','test_date','session','reporting_time',
        'conduct_time','venue'
    ];
}

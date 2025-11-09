<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodIssuance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'department_id',
        'issue_to',
        'requestor_id',
        'release_by',
        'taken_by',
        'expiration_date',
        'date_of_crossmatch',
        'blood_type',
        'blood_bag_id',
        'time_of_crossmatch',
        'release_date',
    ];
}

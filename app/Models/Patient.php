<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'email',
        'contact_number',
        'birth_date',
        'gender',
        'civil_status',
        'province',
        'city',
        'barangay',
        'with_account',
        'status',
    ];
}

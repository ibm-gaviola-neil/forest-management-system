<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
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
        'blood_type',
        'with_account',
        'status',
        'is_approved',
        'valid_id_image',
        'id_type',
        'temp_p'
    ];
}

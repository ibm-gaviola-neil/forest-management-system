<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_settings_id',
        'user_id',
        'email_address',
        'email_password'
    ];
}

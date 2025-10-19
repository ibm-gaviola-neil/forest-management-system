<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSettings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "is_enable",
        "display_start_date",
        "display_end_date",
        "logo",
        "navbar_logo"
    ];
}

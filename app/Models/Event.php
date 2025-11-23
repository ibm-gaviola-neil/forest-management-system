<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'display_start_date',
        'display_end_date',
        'created_at',
        'updated_at',
        'image'
    ];
}

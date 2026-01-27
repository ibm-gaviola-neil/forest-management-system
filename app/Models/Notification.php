<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'related_id',
        'related_table',
        'is_read',
        'created_by',
        'reciever_id'
    ];
}

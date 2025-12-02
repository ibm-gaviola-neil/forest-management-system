<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChainsawRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'brand',
        'model',
        'bar_length',
        'engine_displacement',
        'date_acquisition',
        'description',
        'user_id',
        'status',
    ];
}

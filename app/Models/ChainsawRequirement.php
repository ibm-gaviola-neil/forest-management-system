<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChainsawRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'chainsaw_request_id',
        'file_name',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function chainsaw()
    {
        return $this->belongsTo(ChainsawRequest::class);
    }
}

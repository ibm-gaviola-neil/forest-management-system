<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'file_extension',
        'is_image',
        'is_video',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}

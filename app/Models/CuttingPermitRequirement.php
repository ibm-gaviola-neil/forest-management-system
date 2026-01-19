<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuttingPermitRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'cutting_permit_id',
        'file_name',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function cuttingPermit()
    {
        return $this->belongsTo(CuttingPermit::class);
    }
}

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
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reject($reason = null): void
    {
        $this->update([
            'status' => 2,
            'rejected_at' => now(),
            'rejected_by' => auth()->user()->id,
            'rejection_reason' => $reason,
        ]);
    }

    public function approve(): void
    {
        $this->update([
            'status' => 1,
            'approved_at' => now(),
            'approved_by' => auth()->user()->id,
        ]);
    }

    public function requirements()
    {
        return $this->hasMany(ChainsawRequirement::class);
    }
}

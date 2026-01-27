<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    use HasFactory;

    protected $fillable = [
        'treeId',
        'treeType',
        'datePlanted',
        'height',
        'diameter',
        'location',
        'description',
        'user_id',
        'date_of_cut',
        'status',
        'lattitude',
        'longitude',
        "land_mark",
        "status",
        "rejected_at",
        "rejected_by",
        "rejection_reason",
    ];

    public const TREE_TYPES = [
        'Fruit-Bearing' => 'Fruit-Bearing',
        'Timber'        => 'Timber',
        'Medicinal'     => 'Medicinal',
        'Ornamental'    => 'Ornamental',
    ];

    public function markAsCut()
    {
        $this->update([
            'status' => 4,
        ]);
    }

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

    public function incident()
    {
        return $this->hasMany(Incident::class);
    }
}

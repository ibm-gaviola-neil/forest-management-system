<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        // Reporter information
        'user_id',
        'reporter_name',
        'reporter_email',
        'reporter_phone',
        'is_anonymous',

        // Incident details
        'incident_type',
        'description',
        'incident_date',

        // Location details
        'location',
        'latitude',
        'longitude',
        'landmark',

        // Status and administration
        'status',
        'assigned_to',
        'admin_notes',
        'resolved_at',

        // Evidence & attachments
        'has_photos',
        'has_videos',

        // Severity & priority
        'severity',
        'priority',

        // Related entities
        'related_tree_id',
        'related_permit_id',

        // Meta data
        'reported_from_ip',
        'reported_from_device',
    ];

    public function attachments()
    {
        return $this->hasMany(IncidentAttachment::class);
    }

    public function tree()
    {
        return $this->belongsTo(Tree::class, 'related_tree_id', 'id');
    }

    public function cuttingPermit()
    {
        return $this->belongsTo(CuttingPermit::class, 'related_permit_id', 'id');
    }
}

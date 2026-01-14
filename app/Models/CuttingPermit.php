<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuttingPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tree_id',
        'reason',
        'document_path',
        'document_original_name',
        'status',
        'rejection_reason',
        'approved_at',
        'rejected_at',
        'expires_at',
        'approved_by',
        'rejected_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_EXPIRED = 3;

    // Status labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_EXPIRED => 'Expired',
        ];
    }

    // Get status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    // Get status badge class for styling
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            self::STATUS_EXPIRED => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tree(): BelongsTo
    {
        return $this->belongsTo(Tree::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    // Method to approve the permit
    public function approve($approvedBy = null, $expiresAt = null): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'expires_at' => $expiresAt ?? now()->addMonths(6), // Default 6 months expiry
            'rejection_reason' => null, // Clear any previous rejection reason
        ]);
    }

    // Method to reject the permit
    public function reject($rejectedBy = null, $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejected_at' => now(),
            'rejected_by' => $rejectedBy,
            'rejection_reason' => $reason,
            'expires_at' => null,
        ]);
    }

    // Method to mark as expired
    public function markAsExpired(): void
    {
        $this->update([
            'status' => self::STATUS_EXPIRED,
        ]);
    }

    // Check if permit is expired based on expires_at date
    public function checkIfExpired(): bool
    {
        if ($this->expires_at && now()->greaterThan($this->expires_at)) {
            $this->markAsExpired();
            return true;
        }
        return false;
    }

    // Get document URL for download
    public function getDocumentUrlAttribute(): string
    {
        return asset('storage/' . $this->document_path);
    }

    // Get formatted file size
    public function getFormattedDocumentSizeAttribute(): string
    {
        if (file_exists(storage_path('app/public/' . $this->document_path))) {
            $bytes = filesize(storage_path('app/public/' . $this->document_path));
            $units = ['B', 'KB', 'MB', 'GB'];
            
            for ($i = 0; $bytes > 1024; $i++) {
                $bytes /= 1024;
            }
            
            return round($bytes, 2) . ' ' . $units[$i];
        }
        
        return 'Unknown';
    }

    // Boot method to handle automatic expiry checking
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($permit) {
            if ($permit->isApproved()) {
                $permit->checkIfExpired();
            }
        });
    }
}
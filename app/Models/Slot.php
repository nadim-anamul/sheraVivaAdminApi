<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_block_id',
        'interviewer_id',
        'start_time',
        'end_time',
        'status',
        'locked_until',
    ];

    protected $casts = [
        'locked_until' => 'datetime',
    ];

    /**
     * Get the availability block that generated this slot.
     */
    public function availabilityBlock(): BelongsTo
    {
        return $this->belongsTo(AvailabilityBlock::class);
    }

    /**
     * Get the interviewer who owns this slot.
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(Interviewer::class);
    }

    /**
     * Get the booking associated with this slot.
     */
    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    /**
     * Helper to verify if the slot is currently bookable.
     */
    public function isAvailable(): bool
    {
        if ($this->status !== 'available') {
            return false;
        }

        if ($this->locked_until && $this->locked_until->isFuture()) {
            return false;
        }

        return true;
    }
}

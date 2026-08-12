<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'candidate_id',
        'interviewer_id',
        'amount_paid',
        'payment_status',
        'payment_trx_id',
        'livekit_room_name',
        'meeting_code',
        'grade_score',
        'feedback_remarks',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'grade_score' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->meeting_code)) {
                $booking->meeting_code = 'vva-'.strtolower(Str::random(4)).'-'.strtolower(Str::random(3));
            }
            if (empty($booking->livekit_room_name)) {
                $booking->livekit_room_name = 'viva_room_'.strtolower(Str::random(8));
            }
        });
    }

    /**
     * Get the slot booked by this booking.
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    /**
     * Get the candidate user who made this booking.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the interviewer assigned to this booking.
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(Interviewer::class);
    }
}

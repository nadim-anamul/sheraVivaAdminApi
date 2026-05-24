<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'grade_score',
        'feedback_remarks',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'grade_score' => 'integer',
    ];

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

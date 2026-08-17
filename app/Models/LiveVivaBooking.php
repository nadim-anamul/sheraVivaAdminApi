<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveVivaBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'interviewer_id',
        'payment_transaction_id',
        'exam_type',
        'target_position',
        'scheduled_at',
        'google_meet_url',
        'recording_url',
        'status',
        'overall_score',
        'board_feedback',
        'recommendations',
        'evaluation_scorecard',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'overall_score' => 'integer',
            'evaluation_scorecard' => 'array',
        ];
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(Interviewer::class);
    }

    public function paymentTransaction(): BelongsTo
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}

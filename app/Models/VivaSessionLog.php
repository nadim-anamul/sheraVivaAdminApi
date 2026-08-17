<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VivaSessionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'candidate_name',
        'exam_type',
        'position',
        'candidate_cv',
        'total_questions',
        'overall_score',
        'verdict',
        'score_breakdown',
        'board_feedback',
        'recommendations',
        'transcript',
        'completed_at',
    ];

    protected $casts = [
        'score_breakdown' => 'array',
        'transcript' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the candidate user associated with this session (if logged in).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

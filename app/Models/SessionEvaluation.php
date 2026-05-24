<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mock_session_id',
        'score',
        'filler_words_count',
        'feedback',
        'recommendations',
    ];

    /**
     * Get the mock session associated with this AI evaluation.
     */
    public function mockSession(): BelongsTo
    {
        return $this->belongsTo(MockSession::class);
    }
}

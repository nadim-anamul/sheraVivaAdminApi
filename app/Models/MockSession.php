<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MockSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'viva_category_id',
        'transcript',
        'viva_date',
    ];

    protected $casts = [
        'transcript' => 'array',
        'viva_date' => 'datetime',
    ];

    /**
     * Get the user candidate who owns this mock session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the viva category configuration of this session.
     */
    public function vivaCategory(): BelongsTo
    {
        return $this->belongsTo(VivaCategory::class);
    }

    /**
     * Get the AI evaluation dashboard details for this session.
     */
    public function sessionEvaluation(): HasOne
    {
        return $this->hasOne(SessionEvaluation::class);
    }
}

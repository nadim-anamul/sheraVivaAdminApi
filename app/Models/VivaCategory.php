<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VivaCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'group_type',
        'slug',
        'title',
        'subtitle',
        'icon_name',
        'color_hex',
        'master_direction',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get parent major category if this is a subcategory.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(VivaCategory::class, 'parent_id');
    }

    /**
     * Get subcategories under this major category.
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(VivaCategory::class, 'parent_id');
    }

    /**
     * Get the mock sessions associated with this category.
     */
    public function mockSessions(): HasMany
    {
        return $this->hasMany(MockSession::class);
    }

    /**
     * Get the live viva sessions associated with this category.
     */
    public function liveVivaSessions(): HasMany
    {
        return $this->hasMany(LiveVivaBooking::class, 'exam_type', 'title');
    }
}

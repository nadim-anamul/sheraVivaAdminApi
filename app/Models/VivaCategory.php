<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VivaCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'icon_name',
        'color_hex',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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
        return $this->hasMany(LiveVivaSession::class);
    }
}

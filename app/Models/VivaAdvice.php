<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VivaAdvice extends Model
{
    use HasFactory;

    protected $table = 'viva_advices';

    protected $fillable = [
        'title',
        'category',
        'content',
        'tips',
        'is_active',
    ];

    protected $casts = [
        'tips' => 'array',
        'is_active' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VivaPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'credits',
        'price_bdt',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'credits' => 'integer',
            'price_bdt' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}

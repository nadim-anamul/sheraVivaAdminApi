<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'organization',
        'file_url',
        'file_size',
        'published_date',
    ];

    protected $casts = [
        'published_date' => 'date',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'exam_type',
        'title',
        'edition',
        'year',
        'candidate_name',
        'subject',
        'district',
        'upazila',
        'board',
        'choices',
        'duration',
        'result',
        'experience_rating',
        'remarks',
        'transcript',
    ];

    protected $casts = [
        'choices' => 'array',
        'transcript' => 'array',
    ];
}

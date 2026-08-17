<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamKnowledgeBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_type',
        'subject_category',
        'title',
        'top_questions',
        'core_topics',
        'chairman_style',
        'source_items_count',
        'last_synthesized_at',
    ];

    protected $casts = [
        'top_questions' => 'array',
        'core_topics' => 'array',
        'last_synthesized_at' => 'datetime',
    ];
}

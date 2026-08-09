<?php

namespace App\Filament\Resources\QuestionBanks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class QuestionBankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('exam_type')
                    ->options([
                        'BCS' => 'BCS Viva',
                        'Bank' => 'Bank Viva',
                        'Primary' => 'Primary Teacher Viva',
                        'Other' => 'Other Exam Board',
                    ])
                    ->required()
                    ->default('BCS'),
                TextInput::make('title')
                    ->required()
                    ->placeholder('e.g. ৪৬তম বিসিএস প্রশাসন ক্যাডার ভাইভা অভিজ্ঞতা ১'),
                TextInput::make('edition')
                    ->placeholder('e.g. ৪৬তম'),
                TextInput::make('year')
                    ->placeholder('e.g. ২০২৬'),
                TextInput::make('candidate_name')
                    ->placeholder('e.g. বেনামী'),
                TextInput::make('subject')
                    ->placeholder('e.g. প্রশাসন / অর্থনীতি / ইংরেজি'),
                TextInput::make('board')
                    ->placeholder('e.g. ব্রি. জেনারেল (অব.) আনোয়ারুল ইসলাম'),
                Select::make('experience_rating')
                    ->options([
                        'Excellent' => 'Excellent',
                        'Good' => 'Good',
                        'Average' => 'Average',
                    ])
                    ->default('Good'),
                Textarea::make('remarks')
                    ->placeholder('Additional notes or remarks...'),
                
                Repeater::make('transcript')
                    ->label('Transcript Conversation Sequence')
                    ->schema([
                        Select::make('speaker')
                            ->options([
                                'Chairman' => 'Chairman',
                                'Board Member 1' => 'Board Member 1',
                                'Board Member 2' => 'Board Member 2',
                                'Candidate' => 'Candidate',
                                'External Examiner' => 'External Examiner',
                            ])
                            ->required()
                            ->default('Chairman')
                            ->searchable(),
                        Textarea::make('text')
                            ->label('Statement / Response')
                            ->required()
                            ->rows(3)
                            ->placeholder('Enter the board question or candidate response here...'),
                    ])
                    ->collapsible()
                    ->defaultItems(2)
                    ->cloneable()
                    ->reorderable()
                    ->itemLabel(fn (array $state): ?string => ($state['speaker'] ?? 'Speaker') . ': ' . (isset($state['text']) ? Str::limit($state['text'], 60) : ''))
                    ->helperText('Manage and reorder the conversation sequence. Click and drag items to change the sequence.')
            ]);
    }
}

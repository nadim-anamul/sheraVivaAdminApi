<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\VivaCategory;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function showPracticePage()
    {
        $categories = VivaCategory::where('is_active', true)->get();
        return view('viva.practice', compact('categories'));
    }

    public function showLibraryPage(Request $request)
    {
        $examType = $request->query('exam_type', 'BCS');
        $query = \App\Models\QuestionBank::query();

        if ($examType !== 'All') {
            $query->where('exam_type', $examType);
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('board', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('id', 'desc')->paginate(12);

        $advices = \App\Models\VivaAdvice::where('is_active', true)->get();
        $rules = \App\Models\VivaRule::where('is_active', true)->get();

        return view('candidate.library', compact('items', 'examType', 'advices', 'rules'));
    }

    public function showJobUpdatesPage()
    {
        $circulars = \App\Models\JobUpdate::where('type', 'circular')->orderBy('published_date', 'desc')->get();
        $results = \App\Models\JobUpdate::where('type', 'result')->orderBy('published_date', 'desc')->get();

        return view('candidate.job_updates', compact('circulars', 'results'));
    }

    public function showGuidelinesPage(Request $request)
    {
        $examType = $request->query('exam_type', 'all');

        $adviceQuery = \App\Models\VivaAdvice::where('is_active', true);
        $rulesQuery = \App\Models\VivaRule::where('is_active', true);

        if ($examType !== 'all') {
            $adviceQuery->where(function ($q) use ($examType) {
                $q->where('category', $examType)
                  ->orWhere('category', 'general');
            });
            $rulesQuery->where(function ($q) use ($examType) {
                $q->where('category', $examType)
                  ->orWhere('category', 'general')
                  ->orWhere('category', 'do')
                  ->orWhere('category', 'dont')
                  ->orWhere('category', $examType . '_do')
                  ->orWhere('category', $examType . '_dont');
            });
        }

        $advices = $adviceQuery->get();
        $rules = $rulesQuery->get();

        return view('candidate.guidelines', compact('advices', 'rules', 'examType'));
    }
}

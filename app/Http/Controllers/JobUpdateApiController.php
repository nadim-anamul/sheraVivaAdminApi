<?php

namespace App\Http\Controllers;

use App\Models\JobUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobUpdateApiController extends Controller
{
    /**
     * Retrieves all job circulars, with support for search filters.
     */
    public function getCirculars(Request $request): JsonResponse
    {
        $query = JobUpdate::where('type', 'circular');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('organization', 'like', "%$search%");
            });
        }

        $circulars = $query->orderBy('published_date', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $circulars,
        ], 200);
    }

    /**
     * Retrieves all exam results, with support for search filters.
     */
    public function getResults(Request $request): JsonResponse
    {
        $query = JobUpdate::where('type', 'result');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('organization', 'like', "%$search%");
            });
        }

        $results = $query->orderBy('published_date', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $results,
        ], 200);
    }
}

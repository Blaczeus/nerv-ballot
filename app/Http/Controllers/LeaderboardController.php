<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class LeaderboardController extends Controller
{
    /**
     * Display the top contestants ranked by votes.
     */
    public function index(Request $request): Response
    {
        $page = max(1, min(100, (int) $request->input('page', 1)));
        $contestId = $request->integer('contest_id') ?: 'all';

        $contestants = Cache::remember("leaderboard_{$contestId}_page_{$page}", 30, function () use ($page, $request) {
            $query = Contestant::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                    'image',
                    'total_votes',
                    'contest_id',
                ])
                ->with([
                    'contest:id,name,slug',
                ])
                ->whereNull('deleted_at')
                ->orderByDesc('total_votes');

            if ($request->filled('contest_id')) {
                $query->where('contest_id', $request->integer('contest_id'));
            }

            return $query->paginate(12, ['*'], 'page', $page)->withQueryString();
        });

        if ($contestants->lastPage() > 0 && $page > $contestants->lastPage()) {
            $page = $contestants->lastPage();
            $contestId = $request->integer('contest_id') ?: 'all';

            $contestants = Cache::remember("leaderboard_{$contestId}_page_{$page}", 30, function () use ($page, $request) {
                $query = Contestant::query()
                    ->select([
                        'id',
                        'name',
                        'slug',
                        'image',
                        'total_votes',
                        'contest_id',
                    ])
                    ->with([
                        'contest:id,name,slug',
                    ])
                    ->whereNull('deleted_at')
                    ->orderByDesc('total_votes');

                if ($request->filled('contest_id')) {
                    $query->where('contest_id', $request->integer('contest_id'));
                }

                return $query->paginate(12, ['*'], 'page', $page)->withQueryString();
            });
        }

        return Inertia::render('Leaderboard', [
            'contestants' => $contestants,
        ]);
    }
}

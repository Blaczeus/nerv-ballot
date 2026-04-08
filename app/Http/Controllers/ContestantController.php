<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContestantController extends Controller
{
    /**
     * Display a paginated listing of contestants.
     */
    public function index(Request $request): Response
    {
        $page = max(1, min(100, (int) $request->input('page', 1)));

        $query = Contestant::query()
            ->select([
                'id',
                'name',
                'slug',
                'image',
                'total_votes',
                'contest_id',
                'category',
                'gender',
                'location',
                'description',
                'created_at',
            ])
            ->with([
                'contest:id,name,slug,start_date,end_date',
            ])
            ->whereNull('deleted_at');

        $query
            ->when($request->filled('contest'), fn ($contestantQuery) => $contestantQuery->contestSlug($request->string('contest')->toString()))
            ->when($request->filled('category'), fn ($contestantQuery) => $contestantQuery->category($request->string('category')->toString()))
            ->when($request->filled('location'), fn ($contestantQuery) => $contestantQuery->location($request->string('location')->toString()))
            ->when($request->filled('gender'), fn ($contestantQuery) => $contestantQuery->gender($request->string('gender')->toString()))
            ->when($request->filled('min_votes'), fn ($contestantQuery) => $contestantQuery->minVotes((int) $request->input('min_votes')))
            ->when($request->filled('max_votes'), fn ($contestantQuery) => $contestantQuery->maxVotes((int) $request->input('max_votes')))
            ->when($request->boolean('active'), fn ($contestantQuery) => $contestantQuery->activeContest());

        switch ($request->input('sort')) {
            case 'name-az':
                $query->orderBy('name');
                break;
            case 'recent':
                $query->latest();
                break;
            case 'most-votes':
            default:
                $query->orderByDesc('total_votes');
                break;
        }

        $contestants = $query->paginate(12, ['*'], 'page', $page)->withQueryString();

        if ($contestants->lastPage() > 0 && $page > $contestants->lastPage()) {
            $page = $contestants->lastPage();
            $contestants = $query->paginate(12, ['*'], 'page', $page)->withQueryString();
        }

        $voteBounds = Contestant::query()
            ->whereNull('deleted_at')
            ->selectRaw('COALESCE(MIN(total_votes), 0) as min_votes, COALESCE(MAX(total_votes), 0) as max_votes')
            ->first();

        $contestOptions = Contest::query()
            ->select(['id', 'name', 'slug'])
            ->orderBy('name')
            ->get()
            ->map(fn (Contest $contest): array => [
                'label' => $contest->name,
                'value' => $contest->slug,
            ]);

        $categoryOptions = Contestant::query()
            ->whereNull('deleted_at')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->values();

        $locationOptions = Contestant::query()
            ->whereNull('deleted_at')
            ->whereNotNull('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->values();

        $genderOptions = Contestant::query()
            ->whereNull('deleted_at')
            ->whereNotNull('gender')
            ->distinct()
            ->orderBy('gender')
            ->pluck('gender')
            ->values();

        return Inertia::render('Contestants/Index', [
            'contestants' => [
                'data' => $contestants->getCollection()->map(fn (Contestant $contestant): array => [
                    'id' => $contestant->id,
                    'name' => $contestant->name,
                    'slug' => $contestant->slug,
                    'image' => $contestant->image,
                    'total_votes' => $contestant->total_votes,
                    'contest_id' => $contestant->contest_id,
                    'category' => $contestant->category,
                    'gender' => $contestant->gender,
                    'location' => $contestant->location,
                    'description' => $contestant->description,
                    'created_at' => $contestant->created_at?->toISOString(),
                    'contest' => $contestant->contest ? [
                        'id' => $contestant->contest->id,
                        'name' => $contestant->contest->name,
                        'slug' => $contestant->contest->slug,
                        'start_date' => $contestant->contest->start_date?->toISOString(),
                        'end_date' => $contestant->contest->end_date?->toISOString(),
                    ] : null,
                ])->values(),
                'meta' => [
                    'current_page' => $contestants->currentPage(),
                    'from' => $contestants->firstItem(),
                    'last_page' => $contestants->lastPage(),
                    'links' => $contestants->linkCollection()->toArray(),
                    'path' => $contestants->path(),
                    'per_page' => $contestants->perPage(),
                    'to' => $contestants->lastItem(),
                    'total' => $contestants->total(),
                ],
            ],
            'filterOptions' => [
                'contests' => $contestOptions,
                'categories' => $categoryOptions,
                'locations' => $locationOptions,
                'genders' => $genderOptions,
            ],
            'voteBounds' => [
                'min_votes' => (int) ($voteBounds->min_votes ?? 0),
                'max_votes' => (int) ($voteBounds->max_votes ?? 0),
            ],
        ]);
    }

    /**
     * Display the specified contestant.
     */
    public function show(string $slug): Response
    {
        $contestant = Contestant::query()
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
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();

        return Inertia::render('Contestants/Show', [
            'contestant' => $contestant,
        ]);
    }

    /**
     * Return contestant summaries for vote cart rendering.
     */
    public function cartItems(Request $request): JsonResponse
    {
        $ids = collect($request->input('ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return response()->json([
                'contestants' => [],
            ]);
        }

        $contestants = Contestant::query()
            ->select([
                'id',
                'name',
                'slug',
                'image',
                'total_votes',
                'contest_id',
            ])
            ->with('contest:id,name')
            ->whereIn('id', $ids)
            ->whereNull('deleted_at')
            ->get()
            ->map(fn (Contestant $contestant): array => [
                'id' => $contestant->id,
                'name' => $contestant->name,
                'slug' => $contestant->slug,
                'image' => $contestant->image,
                'total_votes' => $contestant->total_votes,
                'contest_id' => $contestant->contest_id,
                'contest_name' => $contestant->contest?->name,
            ])
            ->values();

        return response()->json([
            'contestants' => $contestants,
        ]);
    }
}

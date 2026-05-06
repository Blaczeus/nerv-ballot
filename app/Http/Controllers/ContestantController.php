<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Contestant;
use Illuminate\Database\Eloquent\Builder;
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
        $contestId = $request->filled('contest_id') ? max(1, (int) $request->input('contest_id')) : null;
        $contestSlug = trim((string) $request->input('contest', ''));
        $category = trim((string) $request->input('category', ''));
        $location = trim((string) $request->input('location', ''));
        $gender = trim((string) $request->input('gender', ''));
        $sort = trim((string) $request->input('sort', 'votes_desc'));
        $voteBounds = Contestant::query()
            ->whereNull('deleted_at')
            ->selectRaw('COALESCE(MIN(total_votes), 0) as min_votes, COALESCE(MAX(total_votes), 0) as max_votes')
            ->first();

        $minimumVotesBound = (int) ($voteBounds?->min_votes ?? 0);
        $maximumVotesBound = max($minimumVotesBound, (int) ($voteBounds?->max_votes ?? 0));
        $hasMinimumVotesFilter = $request->filled('min_votes');
        $hasMaximumVotesFilter = $request->filled('max_votes');
        $minimumVotes = $hasMinimumVotesFilter
            ? min(
                $maximumVotesBound,
                max($minimumVotesBound, (int) $request->input('min_votes')),
            )
            : $minimumVotesBound;
        $maximumVotes = $hasMaximumVotesFilter
            ? max(
                $minimumVotesBound,
                min($maximumVotesBound, (int) $request->input('max_votes')),
            )
            : $maximumVotesBound;

        if ($minimumVotes > $maximumVotes) {
            $maximumVotes = $minimumVotes;
        }

        $query = Contestant::query()
            ->with('contest:id,name,slug,start_date,end_date')
            ->whereNull('deleted_at');

        $query->when($contestId !== null, fn (Builder $contestantQuery) => $contestantQuery->where('contest_id', $contestId));
        $query->when($contestSlug !== '', fn (Builder $contestantQuery) => $contestantQuery->whereHas('contest', function (Builder $contestQuery) use ($contestSlug): void {
            $contestQuery->where('slug', $contestSlug);
        }));
        $query->when($request->filled('category'), fn (Builder $contestantQuery) => $contestantQuery->whereHas('contest', function (Builder $contestQuery) use ($category): void {
            $contestQuery->where('category', trim($category));
        }));
        $query->when($request->filled('gender'), fn (Builder $contestantQuery) => $contestantQuery->where('gender', trim($gender)));
        $query->when($request->filled('location'), fn (Builder $contestantQuery) => $contestantQuery->where('location', trim($location)));
        $query->when($hasMinimumVotesFilter, fn (Builder $contestantQuery) => $contestantQuery->where('total_votes', '>=', $minimumVotes));
        $query->when($hasMaximumVotesFilter, fn (Builder $contestantQuery) => $contestantQuery->where('total_votes', '<=', $maximumVotes));
        $query->when($request->boolean('active'), fn (Builder $contestantQuery) => $contestantQuery->whereHas('contest', function (Builder $contestQuery): void {
            $contestQuery
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        }));
        $query->when($sort === 'votes_desc', fn (Builder $contestantQuery) => $contestantQuery->orderByDesc('total_votes'));
        $query->when($sort === 'votes_asc', fn (Builder $contestantQuery) => $contestantQuery->orderBy('total_votes'));

        if (! in_array($sort, ['votes_desc', 'votes_asc'], true)) {
            $query->orderByDesc('total_votes');
        }

        $contestants = $query->paginate(12, ['*'], 'page', $page)->withQueryString();

        if ($contestants->lastPage() > 0 && $page > $contestants->lastPage()) {
            $page = $contestants->lastPage();
            $contestants = $query->paginate(12, ['*'], 'page', $page)->withQueryString();
        }

        $categoryOptions = Contest::query()
            ->whereHas('contestants', fn (Builder $contestantQuery) => $contestantQuery->whereNull('deleted_at'))
            ->whereNotNull('category')
            ->where('category', '!=', '')
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

        $contestOptions = Contest::query()
            ->whereHas('contestants', fn (Builder $contestantQuery) => $contestantQuery->whereNull('deleted_at'))
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Contest $contest): array => [
                'label' => $contest->name,
                'value' => $contest->id,
            ])
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
                    'contest_status' => $contestant->contest?->status(),
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
                'min_votes' => $minimumVotesBound,
                'max_votes' => $maximumVotesBound,
            ],
            'filters' => [
                'contest_id' => $contestId,
                'contest' => $contestSlug !== '' ? $contestSlug : null,
                'category' => $category !== '' ? $category : null,
                'gender' => $gender !== '' ? $gender : null,
                'location' => $location !== '' ? $location : null,
                'min_votes' => $minimumVotes,
                'max_votes' => $maximumVotes,
                'active' => $request->boolean('active'),
                'sort' => in_array($sort, ['votes_desc', 'votes_asc'], true) ? $sort : 'votes_desc',
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
                'category',
                'gender',
                'location',
                'description',
                'created_at',
            ])
            ->with([
                'contest:id,name,slug,start_date,end_date',
            ])
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->firstOrFail();

        return Inertia::render('Contestants/Show', [
            'contestant' => [
                'id' => $contestant->id,
                'contest_id' => $contestant->contest_id,
                'slug' => $contestant->slug,
                'name' => $contestant->name,
                'contestName' => $contestant->contest?->name ?? 'Contest',
                'category' => $contestant->category ?? 'Uncategorized',
                'gender' => $contestant->gender ?? 'unknown',
                'location' => $contestant->location ?? 'unspecified',
                'contest_status' => $contestant->contest?->status(),
                'votes' => $contestant->total_votes,
                'contestStart' => $contestant->contest?->start_date?->toISOString() ?? '',
                'contestEnd' => $contestant->contest?->end_date?->toISOString() ?? '',
                'createdAt' => $contestant->created_at?->toISOString() ?? '',
                'image' => $contestant->image,
                'hoverImage' => $contestant->image,
                'images' => array_values(array_filter([
                    $contestant->image,
                ])),
                'description' => $contestant->description ?? '',
            ],
        ]);
    }

    /**
     * Return contestants for search and quick actions.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));

        if ($query === '') {
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
                'category',
                'gender',
                'location',
                'description',
                'created_at',
            ])
            ->with('contest:id,name,slug,start_date,end_date')
            ->whereNull('deleted_at')
            ->where(function ($contestantQuery) use ($query): void {
                $contestantQuery
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%")
                    ->orWhereHas('contest', function ($contestQuery) use ($query): void {
                        $contestQuery->where('name', 'like', "%{$query}%");
                    });
            })
            ->orderByDesc('total_votes')
            ->limit(8)
            ->get()
            ->map(fn (Contestant $contestant): array => [
                'id' => $contestant->id,
                'contest_id' => $contestant->contest_id,
                'slug' => $contestant->slug,
                'name' => $contestant->name,
                'contestName' => $contestant->contest?->name ?? 'Contest',
                'category' => $contestant->category ?? 'Uncategorized',
                'gender' => $contestant->gender ?? 'unknown',
                'location' => $contestant->location ?? 'unspecified',
                'contest_status' => $contestant->contest?->status(),
                'votes' => $contestant->total_votes,
                'contestStart' => $contestant->contest?->start_date?->toISOString() ?? '',
                'contestEnd' => $contestant->contest?->end_date?->toISOString() ?? '',
                'createdAt' => $contestant->created_at?->toISOString() ?? '',
                'image' => $contestant->image ?? '/tmp/images/products/womens/women-19.jpg',
                'hoverImage' => $contestant->image ?? '/tmp/images/products/womens/women-19.jpg',
                'description' => $contestant->description ?? '',
            ])
            ->values();

        return response()->json([
            'contestants' => $contestants,
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
                'contest_id',
            ])
            ->with('contest:id,name,start_date,end_date')
            ->whereIn('id', $ids)
            ->whereNull('deleted_at')
            ->get()
            ->map(fn (Contestant $contestant): array => [
                'id' => $contestant->id,
                'contest_id' => $contestant->contest_id,
                'name' => $contestant->name,
                'slug' => $contestant->slug,
                'image' => $contestant->image,
                'contest_name' => $contestant->contest?->name ?? 'Contest',
                'contest_status' => $contestant->contest?->status(),
            ])
            ->values();

        return response()->json([
            'contestants' => $contestants,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contestant extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::saved(function (Contestant $contestant): void {
            self::flushLeaderboardCache($contestant->contest_id);
        });

        static::deleted(function (Contestant $contestant): void {
            self::flushLeaderboardCache($contestant->contest_id);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'category',
        'gender',
        'location',
        'description',
        'total_votes',
        'contest_id',
    ];

    /**
     * Get the contest that the contestant belongs to.
     */
    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Get the votes for the contestant.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Scope a query by contestant gender.
     */
    public function scopeGender(Builder $query, string $gender): Builder
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope a query by contestant location.
     */
    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query by contestant category.
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query by contest slug.
     */
    public function scopeContestSlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('contest', fn (Builder $contestQuery) => $contestQuery->where('slug', $slug));
    }

    /**
     * Scope a query to active contests only.
     */
    public function scopeActiveContest(Builder $query): Builder
    {
        return $query->whereHas('contest', function (Builder $contestQuery): void {
            $contestQuery
                ->where(function (Builder $dateQuery): void {
                    $dateQuery
                        ->whereNull('start_date')
                        ->orWhere('start_date', '<=', now());
                })
                ->where(function (Builder $dateQuery): void {
                    $dateQuery
                        ->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                });
        });
    }

    /**
     * Scope a query by minimum total votes.
     */
    public function scopeMinVotes(Builder $query, int $votes): Builder
    {
        return $query->where('total_votes', '>=', $votes);
    }

    /**
     * Scope a query by maximum total votes.
     */
    public function scopeMaxVotes(Builder $query, int $votes): Builder
    {
        return $query->where('total_votes', '<=', $votes);
    }

    /**
     * Flush leaderboard cache entries for all pages or a specific contest.
     */
    public static function flushLeaderboardCache(?int $contestId = null): void
    {
        foreach (range(1, 100) as $page) {
            cache()->forget("leaderboard_all_page_{$page}");

            if ($contestId) {
                cache()->forget("leaderboard_{$contestId}_page_{$page}");
            }
        }
    }
}

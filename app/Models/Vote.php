<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(function (Vote $vote): void {
            $contestId = Contestant::query()
                ->whereKey($vote->contestant_id)
                ->value('contest_id');

            Contestant::flushLeaderboardCache($contestId ? (int) $contestId : null);
        });

        static::deleted(function (Vote $vote): void {
            $contestId = Contestant::query()
                ->whereKey($vote->contestant_id)
                ->value('contest_id');

            Contestant::flushLeaderboardCache($contestId ? (int) $contestId : null);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_id',
        'user_id',
        'voter_token',
        'contestant_id',
        'contest_id',
        'votes_count',
    ];

    /**
     * Get the transaction that owns the vote.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the user that owns the vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contestant that received the vote.
     */
    public function contestant(): BelongsTo
    {
        return $this->belongsTo(Contestant::class);
    }
}

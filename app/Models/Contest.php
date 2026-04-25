<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'start_date',
        'end_date',
    ];

    /**
     * Get the contestants for the contest.
     */
    public function contestants(): HasMany
    {
        return $this->hasMany(Contestant::class);
    }

    /**
     * Get the votes for the contest.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function isActive(): bool
    {
        return $this->status() === 'active';
    }

    public function status(): string
    {
        $now = now();

        if ($this->start_date && $this->start_date->gt($now)) {
            return 'upcoming';
        }

        if ($this->end_date && $this->end_date->lt($now)) {
            return 'ended';
        }

        return 'active';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    /**
     * Disable the updated_at timestamp.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'skill_level',
        'gender_id',
    ];

    /**
     * Relation to Gender model
     *
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Relation to Skill model
     *
     * @return BelongsToMany
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skill::class,
            'players_skills'
        )->as('player_score')->withPivot('score');
    }

    /**
     * Relation to the tournaments in which the player has participated
     *
     * @return BelongsToMany
     */
    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'participants');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'unit_id',
        'gender_id',
    ];

    // Model data constants
    const STRENGTH = 1;
    const SPEED = 2;
    const REACTION_TIME = 3;

    /**
     * Relation to SkillUnit model.
     *
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(SkillUnit::class);
    }

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
     * Relation to Player model
     *
     * @return BelongsToMany
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(
            Player::class,
            'players_skills'
        )->as('skill_score')->withPivot('score');
    }
}

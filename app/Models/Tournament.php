<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tournament extends Model
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
        'gender_id',
        'winner_id',
    ];

    /**
     * Relation to the Gender model
     *
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Relation to the winner player of the tournament
     *
     * @return void
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Relation to the players of the tournament
     *
     * @return BelongsToMany
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'participants');
    }
}

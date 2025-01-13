<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillUnit extends Model
{
    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'symbol',
    ];

    // Model data constants
    const METERS_PER_SECOND = 1;
    const KM_PER_HOUR = 2;
    const MILISECONDS = 3;
}

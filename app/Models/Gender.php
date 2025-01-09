<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['name'];

    // Model data constants
    const FEMALE = 1;
    const MALE = 2;
}

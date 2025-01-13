<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('score');
            $table->unsignedBigInteger('player_id');
            $table->unsignedTinyInteger('skill_id');
            // FKs definition
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('skill_id')->references('id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players_skills');
    }
};

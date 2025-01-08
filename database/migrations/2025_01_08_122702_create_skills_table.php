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
        Schema::create('skills', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->unsignedTinyInteger('unit_id');
            $table->unsignedTinyInteger('gender_id');
            // FKs definition
            $table->foreign('unit_id')->references('id')->on('skill_units');
            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};

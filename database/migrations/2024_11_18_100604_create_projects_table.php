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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('project_url');
            $table->string('thumbnail')->nullable();
            $table->timestamps();

            $table->unique(['title', 'profile_id']);
            $table->unique(['slug', 'profile_id']);
            $table->unique(['project_url', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

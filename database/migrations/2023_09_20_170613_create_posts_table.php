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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
        });

        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('title');
            $table->text('short_description');
            $table->text('description');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['post_id', 'locale']);
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_translation');
    }
};

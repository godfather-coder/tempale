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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });
        Schema::create('section_translations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('short_description');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unsignedBigInteger('section_id');

            $table->unique(['section_id', 'locale']);
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

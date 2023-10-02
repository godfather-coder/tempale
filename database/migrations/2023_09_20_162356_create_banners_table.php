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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('banner_translations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('locale')->index();
            $table->unsignedBigInteger('banner_id');
            $table->text('text');
            $table->text('link');

            $table->unique(['banner_id', 'locale']);
            $table->foreign('banner_id')->references('id')->on('banners')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
        Schema::dropIfExists('banner_translation');
    }
};

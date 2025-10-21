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
        Schema::create('gnews_tops', function (Blueprint $table) {
            $table->id();
            $table->string('article_id')->unique();
            $table->string('title');
            // $table->string('category')->default('general');
            $table->unsignedTinyInteger('category')->default(0);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            // $table->string('url')->nullable();
            // $table->string('image')->nullable();
            $table->string('published_at')->nullable();
            $table->string('language', 5)->nullable();
            $table->string('source_id')->nullable();
            $table->string('source_name')->nullable();
            // $table->string('source_url')->nullable();
            $table->string('source_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gnews_tops');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->boolean('requires_zone_id')->default(false);
            $table->string('user_id_label')->default('User ID');
            $table->string('zone_id_label')->default('Zone ID');
            $table->string('user_id_regex')->nullable(); // validation pattern
            $table->string('zone_id_regex')->nullable(); // validation pattern
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

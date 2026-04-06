<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['diamond', 'skin', 'voucher', 'weekly_pass', 'monthly_pass', 'other'])->default('diamond');
            $table->decimal('price', 12, 2);
            $table->decimal('original_price', 12, 2)->nullable(); // for showing discount
            $table->integer('amount')->default(0);   // e.g. 86 diamonds
            $table->string('unit')->default('Diamond'); // Diamond, Skin, etc.
            $table->integer('stock')->default(-1);   // -1 = unlimited
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['category_id', 'is_active', 'sort_order']);
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

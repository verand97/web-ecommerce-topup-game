<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // e.g. VS-20240101-XXXXX
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->decimal('total_price', 12, 2);
            $table->string('player_user_id');    // Game User ID
            $table->string('player_zone_id')->nullable(); // Game Zone ID (optional per game)
            $table->string('player_nickname')->nullable(); // resolved after order
            $table->enum('status', [
                'pending',      // payment not started
                'paid',         // payment confirmed
                'processing',   // being processed / sent to game API
                'completed',    // top-up delivered
                'failed',       // failed to deliver
                'cancelled',    // user cancelled
                'refunded',     // refunded
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

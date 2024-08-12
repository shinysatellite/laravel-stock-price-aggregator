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
        Schema::create('stock_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 4);
            $table->decimal('previous_price', 10, 4)->nullable();
            $table->decimal('percentage_change', 8, 4)->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index(['stock_id', 'timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_prices');
    }
};

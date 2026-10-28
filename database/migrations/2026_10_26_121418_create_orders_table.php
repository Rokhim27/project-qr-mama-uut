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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->foreignId('restaurant_table_id')
            ->constrained('restaurant_tables')
            ->restrictOnDelete();

        $table->string('order_number')->unique();
        $table->string('customer_name')->nullable();
        $table->text('notes')->nullable();
        $table->decimal('total_amount', 12, 2)->default(0);

        $table->enum('status', [
            'pending',
            'confirmed',
            'preparing',
            'completed',
            'cancelled',
        ])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

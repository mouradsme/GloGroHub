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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the user who placed the order
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link to the ordered product
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2); // Total price of the order
            $table->enum('status', ['pending', 'completed', 'cancelled', 'available', 'out_of_stock', 'discontinued', 'cart'])->default('cart');
            $table->timestamp('ordered_at')->useCurrent(); // When the order was placed
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

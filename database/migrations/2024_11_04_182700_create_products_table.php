<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('ethnic_culture')->nullable();
            $table->boolean('seasonal_demand')->default(false);
            $table->boolean('recommended')->default(false);
            $table->float('ai_demand_score', 3, 2)->default(0.0);
            $table->float('cultural_relevance_score', 3, 2)->default(0.0);
            $table->integer('min_order_quantity')->default(1);
            $table->string('unit')->default('piece');
            $table->string('sku')->unique();
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

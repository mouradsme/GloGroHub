<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumInOrdersTable extends Migration
{
    public function up()
    {
        // Update the status enum to add 'cart'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'completed', 'cancelled', 'available', 'out_of_stock', 'discontinued', 'cart') DEFAULT 'available'");
    }

    public function down()
    {
        // Revert the status enum if rolling back
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('available', 'out_of_stock', 'discontinued') DEFAULT 'available'");
    }
}

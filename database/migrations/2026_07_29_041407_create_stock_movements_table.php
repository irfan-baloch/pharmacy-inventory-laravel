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
        Schema::create('stock_movements', function (Blueprint $table) {
            
            $table->id();

            $table->foreignId('medicine_id')
            ->constrained()
            ->onDelete('cascade');

            $table->foreignId('batch_id')
            ->constrained()
            ->onDelete('cascade');

            // 'in' = stock aaya (purchase), 'out' = stock gaya (sale)
            $table->enum('type', ['in', 'out']);

            $table->integer('quantity');                            // Kitni quantity move hui
            $table->decimal('unit_price', 10, 2)->nullable();       // Us waqt ka price
            $table->decimal('total_price', 10, 2)->nullable();      // quantity * unit_price

            // Polymorphic reference - kis sale/purchase se linked hai
            $table->string('reference_type')->nullable();           // e.g., 'sale', 'purchase'
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('notes')->nullable();                      // Koi extra note

            // Kaunse user ne yeh transaction ki
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};

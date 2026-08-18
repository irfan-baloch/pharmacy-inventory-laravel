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
        Schema::create('medicines', function (Blueprint $table) {
            
            $table->id();

            // Foreign key: har medicine ek category ki hoti hai
            $table->foreignId('category_id')
            ->constrained()
            ->onDelete('cascade');

            $table->string('name');                                 // e.g., Panadol 500mg
            $table->string('generic_name')->nullable();             // e.g., Paracetamol
            $table->string('brand')->nullable();                    // e.g., GSK
            $table->text('description')->nullable();                // Usage, side effects etc.
            $table->decimal('unit_price', 10, 2)->default(0);       // Sale price per unit
            $table->string('unit')->default('pcs');                 // pcs, bottle, box, strip
            $table->integer('pack_size')->default(1);               // e.g, 10 (1 strip mein 10 tablets)
            $table->string('pack_unit')->nullable();                // e.g, strip
            $table->integer('low_stock_threshold')->default(10);    // Alert level
            $table->string('image')->nullable();                    // Medicine photo path
            $table->boolean('is_active')->default(true);            // Active/disabled
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

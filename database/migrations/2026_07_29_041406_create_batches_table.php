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
        Schema::create('batches', function (Blueprint $table) {
            
            $table->id();

            // Kis medicine ka batch hai
            $table->foreignId('medicine_id')
            ->constrained()
            ->onDelete('cascade');

            // Kis supplier se aayi (optional - kabhi pata nahi hota)
            $table->foreignId('supplier_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

            $table->string('batch_number');                         // e.g., BATCH-2026-A, PN-12345
            $table->date('expiry_date');                            // e.g., 2026-11-30
            $table->integer('quantity');                            // Total kitni aayi thi
            $table->integer('remaining_quantity');                  // Ab kitni bachi hai (sale ke baad kam)
            $table->decimal('purchase_price', 10, 2)->default(0);   // Per unit purchase cost
            $table->date('purchase_date');                          // Kab kharidi
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};

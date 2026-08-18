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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();                               // Auto-increment primary key
            $table->string('name');                     // e.g., Tablet, Syrup, Injection
            $table->string('slug')->unique();           // URL-friendly name: tablet, syrup
            $table->text('description')->nullable();    // Optional details
            $table->timestamps();                       // created_at + updated_at

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

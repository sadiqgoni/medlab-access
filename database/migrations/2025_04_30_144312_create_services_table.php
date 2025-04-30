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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00)->comment('Base price for the service');
            $table->json('attributes')->nullable()->comment('Defines required input fields: [{\"name\": \"field_name\", \"label\": \"Field Label\", \"type\": \"text|select|number|checkbox\", \"required\": true, \"options\": []}]');
            $table->boolean('is_active')->default(true); // Allow providers to toggle service availability
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

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
            $table->string('name');
            $table->string('category'); // eMedSample or SharedBlood
            $table->decimal('price', 10, 2);
            $table->string('availability_status')->default('available'); // 'available', 'unavailable', 'limited'
            $table->string('turnaround_time')->nullable(); // For tests - e.g. "24 hours"
            $table->text('requirements')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
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

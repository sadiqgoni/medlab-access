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
            $table->foreignId('user_id')->constrained('users')->comment('Consumer who placed the order');
            $table->foreignId('facility_id')->nullable()->constrained('facilities')->comment('Facility processing the order');
            $table->foreignId('biker_id')->nullable()->constrained('users')->comment('Biker assigned for delivery'); // Nullable initially

            $table->enum('order_type', ['test', 'blood']);
            $table->json('details')->nullable()->comment('Test types, blood group, etc.'); // Specifics of the order

            $table->enum('status', [
                'pending',          // Order placed, awaiting facility acceptance
                'accepted',         // Facility accepted, awaiting biker assignment/pickup
                'processing',       // Lab test in progress
                'sample_collected', // Biker picked up sample
                'in_transit',       // Biker is en route (sample or blood)
                'delivered',        // Biker completed delivery (sample to lab, blood to destination)
                'results_ready',    // Lab results uploaded
                'completed',        // Order fully completed (results viewed/blood delivered)
                'cancelled'         // Order cancelled
            ])->default('pending');

            $table->text('pickup_address')->nullable();
            $table->text('delivery_address')->nullable();
            $table->timestamp('pickup_scheduled_time')->nullable();
            $table->timestamp('delivery_scheduled_time')->nullable();
            $table->timestamp('actual_pickup_time')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();

            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway_ref')->nullable()->comment('e.g., Paystack reference');
            $table->decimal('total_amount', 10, 2)->nullable(); // Store amount

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

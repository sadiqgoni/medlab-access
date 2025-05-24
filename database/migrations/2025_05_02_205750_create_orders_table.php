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
            // User relationships
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->foreignId('biker_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Order details
            $table->enum('order_type', ['test', 'blood'])->comment('Type of order: test=laboratory tests, blood=blood products');
            $table->json('details')->nullable()->comment('Dynamic order details like test parameters or blood units');
            $table->string('status')->default('pending')->comment('Order workflow status: pending, accepted, processing, etc.');
            
            // Logistics information
            $table->text('pickup_address')->nullable();
            $table->text('delivery_address')->nullable();
            $table->dateTime('pickup_scheduled_time')->nullable();
            $table->dateTime('delivery_scheduled_time')->nullable();
            $table->dateTime('actual_pickup_time')->nullable();
            $table->dateTime('actual_delivery_time')->nullable();
            
            // Payment information
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway_ref')->nullable()->comment('Reference ID from payment provider');
            $table->decimal('total_amount', 10, 2)->nullable();
            
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

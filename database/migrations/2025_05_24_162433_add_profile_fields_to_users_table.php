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
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('occupation')->nullable();
            
            // Contact Information
            $table->string('emergency_contact')->nullable();
            
            // Medical Information
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('medical_conditions')->nullable();
            
            // Medical Preferences
            $table->boolean('willing_to_donate_blood')->default(false);
            $table->boolean('emergency_contact_consent')->default(false);
            $table->boolean('health_reminders')->default(false);
            
            // Privacy Settings
            $table->boolean('marketing_consent')->default(false);
            $table->boolean('data_sharing_consent')->default(false);
            $table->boolean('location_tracking')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop all the added columns
            $table->dropColumn([
                'date_of_birth',
                'gender',
                'occupation',
                'emergency_contact',
                'allergies',
                'current_medications',
                'medical_conditions',
                'willing_to_donate_blood',
                'emergency_contact_consent',
                'health_reminders',
                'marketing_consent',
                'data_sharing_consent',
                'location_tracking',
            ]);
        });
    }
};

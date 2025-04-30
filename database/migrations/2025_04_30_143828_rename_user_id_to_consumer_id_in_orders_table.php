<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Log; // Import Log facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the constraint exists before trying to drop it
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'user_id')) {
            try {
                 // Use raw SQL to drop the foreign key constraint
                 // Note: Constraint names can vary, this assumes the standard Laravel naming
                DB::statement('ALTER TABLE orders DROP FOREIGN KEY orders_user_id_foreign');
                // Optionally drop the index if it wasn't dropped with the FK
                 // DB::statement('ALTER TABLE orders DROP INDEX orders_user_id_foreign'); 
            } catch (\Exception $e) {
                 // Log or handle the error if the constraint/index doesn't exist or name is different
                 // For now, we'll assume it worked or didn't exist
                 Log::warning('Could not drop orders_user_id_foreign constraint/index: ' . $e->getMessage());
            }
           
            Schema::table('orders', function (Blueprint $table) {
                // Rename user_id to consumer_id
                $table->renameColumn('user_id', 'consumer_id');

                // Re-add foreign key constraint with the new column name
                $table->foreign('consumer_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade'); // Or restrict, set null, etc.
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'consumer_id')) {
            Schema::table('orders', function (Blueprint $table) {
                // Drop the new foreign key constraint first
                $table->dropForeign(['consumer_id']);
            });
            
            // Rename consumer_id back to user_id using raw SQL 
            // (renameColumn might have issues if other constraints depend on it indirectly)
             DB::statement('ALTER TABLE orders CHANGE consumer_id user_id BIGINT UNSIGNED NOT NULL');
            
            // Re-add the old foreign key constraint using the explicit name
             try {
                 DB::statement('ALTER TABLE orders ADD CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
             } catch (\Exception $e) {
                 Log::warning('Could not re-add orders_user_id_foreign constraint: ' . $e->getMessage());
             }
        }
    }
};

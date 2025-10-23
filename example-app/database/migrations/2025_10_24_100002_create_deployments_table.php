<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deployments', function (Blueprint $table) {
            $table->id(); // Primary Key for Deployment

            // Foreign Key to the 'environments' table
            $table->foreignId('environment_id')
                ->constrained() // Creates the foreign key constraint
                ->onDelete('cascade'); // Optional: Deletes deployments if the environment is deleted

            $table->string('commit_hash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deployments');
    }
};
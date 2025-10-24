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
        Schema::create('environments', function (Blueprint $table) {
            $table->id(); // Primary Key for Environment

            // Foreign Key to the 'applications' table
            $table->foreignId('application_id')
                ->constrained() // Creates the foreign key constraint
                ->onDelete('cascade'); // Optional: Deletes environments if the application is deleted

            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environments');
    }
};
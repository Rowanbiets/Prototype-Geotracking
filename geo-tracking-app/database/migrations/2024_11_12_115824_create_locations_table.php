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
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // Primaire sleutel
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Verwijzing naar de gebruikers-tabel
            $table->decimal('latitude', 10, 8); // Breedtegraad
            $table->decimal('longitude', 11, 8); // Lengtegraad
            $table->timestamps(); // Aangemaakt en bijgewerkt tijdstempels
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

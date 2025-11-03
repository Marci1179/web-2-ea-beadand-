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
    Schema::create('results', function (Blueprint $table) {
        $table->id();

        // FK-k
        $table->foreignId('pilot_id')->constrained('pilots')->cascadeOnDelete();
        $table->foreignId('grand_prix_id')->constrained('grands_prix')->cascadeOnDelete();

        // Eredmény + extra mezők (ezek hiányoznak most a tábládból)
        $table->unsignedInteger('place')->nullable(); // helyezés
        $table->string('issue')->nullable();          // hiba / kiesés oka
        $table->string('team')->nullable();           // csapat
        $table->string('chassis')->nullable();        // típus/alváz
        $table->string('engine')->nullable();         // motor

        $table->timestamps();

        $table->unique(['pilot_id', 'grand_prix_id']);
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};

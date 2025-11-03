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
		Schema::create('pilots', function (Blueprint $table) {
			$table->id();
			$table->unsignedInteger('legacy_id')->unique(); // pilota.txt: az
			$table->string('name');
			$table->enum('gender', ['F','N'])->nullable();
			$table->date('birth_date')->nullable();
			$table->string('nationality')->nullable();
			$table->timestamps();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilots');
    }
};

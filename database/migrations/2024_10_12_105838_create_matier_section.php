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
        Schema::create('matier_section', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matier_id');
            $table->unsignedBigInteger('section_id');

            // foreign keys
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('matier_id')->references('id')->on('matiers')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matier_section');
    }
};

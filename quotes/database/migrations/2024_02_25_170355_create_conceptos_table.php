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
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombreConceptoCorto');
            $table->string('nombreConceptoLargo');
            $table->float('precio');
            $table->unsignedBigInteger('idTipo');
            $table->foreign('idTipo')->references('id')->on('tipos_conceptos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};

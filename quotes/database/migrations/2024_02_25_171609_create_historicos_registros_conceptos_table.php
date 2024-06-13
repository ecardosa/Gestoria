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
        Schema::create('historicos_registros_conceptos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('idRegistro');
            $table->integer('idEmpresa');
            $table->string('nombreEmpresa');
            $table->integer('idConcepto');
            $table->string('nombreConceptoCorto');
            $table->string('nombreConceptoLargo');
            $table->float('precio');
            $table->integer('idTipo');
            $table->string('nombreTipo');
            $table->integer('unidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos_registros_conceptos');

    }
};

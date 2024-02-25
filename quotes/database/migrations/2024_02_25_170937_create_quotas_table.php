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
        Schema::create('quotas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('idEmpresa');
            $table->integer('nif');
            $table->unsignedBigInteger('idTipoQuota');
            $table->float('importePropuesta');
            $table->date('fechaPropuesta');
            $table->date('fechaAceptacion');
            $table->date('fechaInicial');
            $table->date('fechaFinal');
            $table->boolean('aceptada');
            $table->string('comentarios');
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            $table->foreign('idTipoQuota')->references('id')->on('tipos_conceptos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotas');
    }
};

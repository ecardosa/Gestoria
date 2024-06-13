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
            $table->unsignedBigInteger('idEmpresa')->nullable();
            $table->integer('nif')->nullable();
            $table->unsignedBigInteger('idTipoQuota')->nullable();
            $table->float('importePropuesta')->nullable();
            $table->date('fechaPropuesta')->nullable();
            $table->date('fechaAceptacion')->nullable();
            $table->date('fechaInicial')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->boolean('aceptada');
            $table->string('comentarios')->nullable();
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

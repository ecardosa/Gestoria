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
        Schema::create('historicos_quotas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('idQuota');
            $table->integer('idEmpresa');
            $table->string('nombreEmpresa');
            $table->integer('nif');
            $table->integer('idTipoQuota')->nullable();
            $table->string('nombreTipoQuota')->nullable();
            $table->float('importePropuesta');
            $table->date('fechaPropuesta')->nullable();
            $table->date('fechaAceptacion')->nullable();
            $table->date('fechaInicial');
            $table->date('fechaFinal');
            $table->boolean('aceptada');
            $table->string('comentarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos_quotas');
    }
};

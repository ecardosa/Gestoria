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
        Schema::create('registros_conceptos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('idEmpresa');
            $table->unsignedBigInteger('idConcepto');
            $table->integer('unidades');
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            $table->foreign('idConcepto')->references('id')->on('conceptos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_conceptos');
    }
};

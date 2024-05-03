<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroConcepto extends Model
{
    use HasFactory;

    protected $table = 'registros_conceptos';

    protected $fillable = [
        'idempresa',
        'idconcepto',
        'unidades',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idempresa');
    }

    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'idconcepto');
    }

    public function historico_registro_concepto()
    {
        return $this->hasMany(HistoricoRegistroConcepto::class, 'idRegistro');
    }
}

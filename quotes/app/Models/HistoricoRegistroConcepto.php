<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoRegistroConcepto extends Model
{
    use HasFactory;

    protected $table = 'historicos_registros_conceptos';

    protected $fillable = [
        'idRegistro',
        'idEmpresa',
        'idConcepto',
        'unidades',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa');
    }

    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'idConcepto');
    }

    public function registro_concepto()
    {
        return $this->belongsTo(RegistroConcepto::class, 'idRegistro');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoQuota extends Model
{
    use HasFactory;

    protected $table = 'historicos_quotas';

    protected $fillable = [
        'idQuota',
        'idEmpresa',
        'nif',
        'idTipoQuota',
        'importePropuesta',
        'fechaPropuesta',
        'fechaAceptacion',
        'fechaInicial',
        'fechaFinal',
        'aceptada',
        'comentarios'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa');
    }

    public function tipoQuota()
    {
        return $this->belongsTo(TipoConcepto::class, 'idTipoQuota');
    }

    public function quota()
    {
        return $this->belongsTo(Quota::class, 'idQuota');
    }
}

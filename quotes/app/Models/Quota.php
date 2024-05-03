<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    protected $table = 'quotas';

    protected $fillable = [
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

}

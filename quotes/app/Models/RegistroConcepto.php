<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Concepto;
use App\Models\HistoricoRegistroConcepto;

class RegistroConcepto extends Model
{
    use HasFactory;

    protected $table = 'registros_conceptos';

    protected $fillable = [
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

    public function historico_registro_concepto()
    {
        return $this->hasMany(HistoricoRegistroConcepto::class, 'idRegistro');
    }
}

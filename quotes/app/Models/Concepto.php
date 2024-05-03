<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreConceptoCorto',
        'nombreConceptoLargo',
        'precio',
        'idTipo'
    ];

    public function tipoConcepto()
    {
        return $this->belongsTo(TipoConcepto::class, 'idTipo');
    }

    public function historicoRegistroConcepto()
    {
        return $this->hasMany(HistoricoRegistroConcepto::class, 'idConcept
        o');
    }
}

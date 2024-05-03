<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConcepto extends Model
{
    use HasFactory;

    protected $table = 'tipos_conceptos';

    protected $fillable = [
        'nombreTipo',
    ];

    public function concepto()
    {
        return $this->hasMany(Concepto::class, 'idtipo');
    }

    public function quota()
    {
        return $this->hasMany(Quota::class, 'idTipoQuota');
    }
}

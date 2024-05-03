<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nomEmpresa',
        'idperfil'
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'idperfil');
    }

    public function registro_concepto()
    {
        return $this->hasMany(RegistroConcepto::class, 'idempresa
        ');
    }

    public function quota()
    {
        return $this->hasMany(Quota::class, 'idEmpresa
        ');
    }

    public function historico_quota()
    {
        return $this->hasMany(HistoricoQuota::class, 'idEmpresa
        ');
    }

    public function historico_registro_concepto()
    {
        return $this->hasMany(HistoricoRegistroConcepto::class, 'idEmpresa
        ');

    }
    
}

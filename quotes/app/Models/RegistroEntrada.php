<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroEntrada extends Model
{
    use HasFactory;

    protected $table = 'registros_entradas';

    protected $fillable = [
        'idUsuario',
        'fecha',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario
        ');
    }
}

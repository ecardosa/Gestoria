<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RegistroConcepto;
use App\Models\RegistroEntrada;
use App\Models\Quota;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        //     'idperfil' => 1,
        // ]);

        // RegistroConcepto::create([
        //     'idempresa' => 1,
        //     'idconcepto' => 1,
        //     'unidades' => 1,
        // ]);

        // RegistroConcepto::create([
        //     'idempresa' => 1,
        //     'idconcepto' => 2,
        //     'unidades' => 2,
        // ]);

        // RegistroConcepto::create([
        //     'idempresa' => 1,
        //     'idconcepto' => 3,
        //     'unidades' => 3,
        // ]);

        Quota::create([
            'idEmpresa' => 1,
            'nif' => 12345678,
            'idTipoQuota' => 1,
            'importePropuesta' => 1000,
            'fechaPropuesta' => '2024-02-25',
            'fechaAceptacion' => '2024-02-25',
            'fechaInicial' => '2024-02-25',
            'fechaFinal' => '2024-02-25',
            'aceptada' => true,
            'comentarios' => 'Comentario de prueba 1',
        ]);

        Quota::create([
            'idEmpresa' => 1,
            'nif' => 12345678,
            'idTipoQuota' => 2,
            'importePropuesta' => 2000,
            'fechaPropuesta' => '2024-02-25',
            'fechaAceptacion' => '2024-02-25',
            'fechaInicial' => '2024-02-25',
            'fechaFinal' => '2024-02-25',
            'aceptada' => true,
            'comentarios' => 'Comentario de prueba 2',
        ]);

        Quota::create([
            'idEmpresa' => 1,
            'nif' => 12345678,
            'idTipoQuota' => 3,
            'importePropuesta' => 3000,
            'fechaPropuesta' => '2024-02-25',
            'fechaAceptacion' => '2024-02-25',
            'fechaInicial' => '2024-02-25',
            'fechaFinal' => '2024-02-25',
            'aceptada' => true,
            'comentarios' => 'Comentario de prueba 3',
        ]);
    }
}

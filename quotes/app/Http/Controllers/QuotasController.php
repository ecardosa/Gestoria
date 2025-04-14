<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quota;
use App\Models\TipoConcepto;
use App\Models\Empresa;
use App\Models\RegistroConcepto;
use App\Models\HistoricoQuota;
use Barryvdh\DomPDF\Facade\Pdf;
use App;

// pdf


class QuotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get quotas with related data from empresa and tipoQuota, empresa with perfil
        $quotas = Quota::with('empresa.perfil', 'tipoQuota')->get();
        return Inertia::render('Quotas/Index', [
            'quotas' => $quotas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quota = Quota::find($id);
        $quota->fill($request->all());
        $quota->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $quota = Quota::find($id);
    // new historicoQuota
    $historicoQuota = new HistoricoQuota();
    $historicoQuota->idQuota = $quota->id;
    $historicoQuota->idEmpresa = $quota->idEmpresa;
    $empresa = Empresa::find($quota->idEmpresa);
    $historicoQuota->nombreEmpresa = $empresa->nomEmpresa;
    $historicoQuota->nif = $quota->nif;
    $historicoQuota->idTipoQuota = $quota->idTipoQuota;
    $tipoQuota = TipoConcepto::find($quota->idTipoQuota);
    $historicoQuota->nombreTipoQuota = 'hola';
    $historicoQuota->importePropuesta = $quota->importePropuesta;
    $historicoQuota->fechaPropuesta = $quota->fechaPropuesta;
    $historicoQuota->fechaAceptacion = $quota->fechaAceptacion;
    $historicoQuota->fechaInicial = $quota->fechaInicial;
    $historicoQuota->fechaFinal = now();
    $historicoQuota->aceptada = $quota->aceptada;
    $historicoQuota->comentarios = $quota->comentarios;
    $historicoQuota->save();
    $quota->delete();

    // make a new quota for the same empresa
    $newQuota = new Quota();
    $newQuota->idEmpresa = $empresa->id;
    $newQuota->nif = '12345678';
    $newQuota->idTipoQuota = null;
    $newQuota->importePropuesta = '0';
    $newQuota->fechaPropuesta = null;
    $newQuota->fechaAceptacion = null;
    $newQuota->fechaInicial = now();
    $newQuota->fechaFinal = null;
    $newQuota->aceptada = false;
    $newQuota->comentarios = 'Encara no hi ha cap comentari';
    $newQuota->save();


    // delete all registers of the company
    $conceptRegisters = RegistroConcepto::where('idEmpresa', $empresa->id)->get();
    foreach ($conceptRegisters as $conceptRegister) {
        $conceptRegister->delete();
    }

    return redirect()->route('companies.show', ['company' => $empresa->id]);
}

public function pdf(string $id)
{
    // Cargar la cuota con todas sus relaciones
    $quota = Quota::with('empresa.registro_concepto.concepto.tipoConcepto', 'empresa.perfil', 'tipoQuota')->find($id);
    
    // 💾 Guardar en el historial
    $historico = new HistoricoQuota();
    $historico->idQuota = $quota->id;
    $historico->idEmpresa = $quota->idEmpresa;
    $historico->nombreEmpresa = $quota->empresa->nomEmpresa;
    $historico->nif = $quota->nif;
    $historico->idTipoQuota = $quota->idTipoQuota;

    // ⚠️ Acceder a nombreTipo de forma segura
    $historico->nombreTipoQuota = optional($quota->tipoQuota)->nombreTipo ?? 'Sense tipus';

    $historico->importePropuesta = $quota->importePropuesta;
    $historico->fechaPropuesta = $quota->fechaPropuesta;
    $historico->fechaAceptacion = $quota->fechaAceptacion;
    $historico->fechaInicial = $quota->fechaInicial;
    $historico->fechaFinal = now(); // ← Fecha de generación del PDF
    $historico->aceptada = $quota->aceptada;
    $historico->comentarios = $quota->comentarios;
    $historico->save();

    // 👇 Configurar PDF
    $company = 'Empresa';
    $date = now();
    $user = auth()->user();
    $logo = public_path('img/logo.png');

    $data = [
        'quota' => $quota,
        'company' => $company,
        'date' => $date,
        'user' => $user,
        'logo' => $logo,
    ];

    $pdf = Pdf::setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ])->loadView('tst', $data);

    return $pdf->download("{$company}_{$quota->empresa->nomEmpresa}_{$quota->id}.pdf");
}

}

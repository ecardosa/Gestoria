<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Inertia\Inertia;
use App\Models\Perfil;
use App\Models\RegistroConcepto;
use App\Models\Concepto;
use App\Models\TipoConcepto;
use App\Models\HistoricoRegistroConcepto;
use App\Models\Quota;
use App\Models\HistoricoQuota;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $profiles = Perfil::all();
        $user = auth()->user();
        // get only the companies who have the same profile as the user, or all companies if the user is admin (company with profiles)
        // $companies = Empresa::with('perfil')->get();
        $companies = $user->is_admin ? Empresa::with('perfil')->get() : Empresa::with('perfil')->where('idperfil', $user->idperfil)->get();
        return Inertia::render('Companies/Index', [
            'companies' => $companies,
            'profiles' => $profiles,
            'user' => $user,
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
        $company = new Empresa();
        $company->nomEmpresa = $request->name;
        $company->idperfil = $request->idperfil;
        $company->save();

        $quota = new Quota();
        $quota->idEmpresa = $company->id;
        $quota->nif = '12345678';
        $quota->idTipoQuota = null;
        $quota->importePropuesta = '0';
        $quota->fechaPropuesta = null;
        $quota->fechaAceptacion = null;
        $quota->fechaInicial = now();
        $quota->fechaFinal = null;
        $quota->aceptada = false;
        $quota->comentarios = 'Encara no hi ha cap comentari';
        $quota->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Empresa::with('perfil', 'registro_concepto.concepto', 'quota')
        ->find($id);
        $user = auth()->user();
        $companies = $user->is_admin ? Empresa::all() : Empresa::where('idperfil', $user->idperfil)->get();
        $concepts = Concepto::with('tipoConcepto')->get();
        $profiles = Perfil::all();
        $conceptType = TipoConcepto::all();
    
        return Inertia::render('Companies/Show', [
            'company' => $company,
            'companies' => $companies,
            'profiles' => $profiles,
            'concepts' => $concepts,
            'conceptType' => $conceptType,
            'user' => $user,
        ]);
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
        $company = Empresa::find($id);
        $company->nomEmpresa = $request->name;
        $company->idperfil = $request->idperfil;
        $company->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // get company with their registers concepts and quota
        $company = Empresa::with('registro_concepto', 'quota')->find($id);
        // delete all registers concepts
        $company->registro_concepto()->delete();
        // add historical quota by quota of the company
        $historic = HistoricoQuota::create([
            'idQuota' => $company->quota->id,
            'idEmpresa' => $company->id,
            'nombreEmpresa' => $company->nomEmpresa,
            'nif' => $company->quota->nif,
            'idTipoQuota' => $company->quota->idTipoQuota,
            'nombreTipoQuota' => 'hola',
            'importePropuesta' => $company->quota->importePropuesta,
            'fechaPropuesta' => $company->quota->fechaPropuesta,
            'fechaAceptacion' => $company->quota->fechaAceptacion,
            'fechaInicial' => $company->quota->fechaInicial,
            'fechaFinal' => now(),
            'aceptada' => $company->quota->aceptada,
            'comentarios' => $company->quota->comentarios,
        ]);
        // delete quota
        $company->quota->delete();
        $company->delete();

        return redirect()->route('companies.index');
    }

       /**
     * Remove concept register from company.
     */
    // public function destroyConceptRegister(string $id, string $idConceptRegister)
    // {
    //     dd($id, $idConceptRegister);
    //     $company = Empresa::find($id);
    //     $company->registro_concepto()->detach($idConceptRegister);

    //     return redirect()->route('companies.show', ['id' => $id]);
    // }

}

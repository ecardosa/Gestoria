<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;   
use App\Models\RegistroConcepto;
use App\Models\Concepto;
use App\Models\Empresa;
use App\Models\HistoricoRegistroConcepto;

class ConceptsRegistersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // conceptsRegisters with company, concept
        $conceptsRegisters = RegistroConcepto::with('empresa', 'concepto')->get();
        return Inertia::render('ConceptsRegisters/Index', [
            'conceptsRegisters' => $conceptsRegisters
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
        $company = Empresa::find($request->companyId);
       
        // if the concept does not exist, create it (by nombreConceptoCorto, Largo, idTipo and precio)
        $concept = Concepto::firstOrCreate([
            'nombreConceptoCorto' => $request->name,
            'nombreConceptoLargo' => $request->namelong,
            'idTipo' => $request->type_id,
            'precio' => $request->price
        ]);


        // create a new concept register, if it does not exist
        $conceptRegister = RegistroConcepto::firstOrCreate([
            'idEmpresa' => $company->id,
            'idConcepto' => $concept->id,
            'unidades' => $request->unity
        ]);

        // create a new historical concept register
        $historicalConceptRegister = HistoricoRegistroConcepto::create([
            'idRegistro' => $conceptRegister->id,
            'idEmpresa' => $company->id,
            'nombreEmpresa' => $company->nomEmpresa,
            'idConcepto' => $concept->id,
            'nombreConceptoCorto' => $concept->nombreConceptoCorto,
            'nombreConceptoLargo' => $concept->nombreConceptoLargo,
            'precio' => $concept->precio,
            'idTipo' => $concept->idTipo,
            'nombreTipo' => $concept->tipoConcepto->nombreTipo,
            'unidades' => $conceptRegister->unidades
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concept = RegistroConcepto::find($id);
        $concept->delete();
    }

    public function storeExistent(Request $request)
{
    $request->validate([
        'company_id' => 'required|exists:empresas,id',
        'concept_id' => 'required|exists:conceptos,id',
        'unity' => 'required|numeric|min:1',
    ]);

    $register = new RegistroConcepto();
    $register->idEmpresa = $request->company_id;
    $register->idConcepto = $request->concept_id;
    $register->unidades = $request->unity;
    $register->save();

    // Cargar relaciones para devolverlo completo
    $register->load('concepto.tipoConcepto');

    return redirect()->back()->with('concept_added', $register);
    // o si usas Inertia:
    // return back()->with('concept_added', $register);
}

}

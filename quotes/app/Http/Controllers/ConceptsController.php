<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;   
use App\Models\Concepto; 
use App\Models\TipoConcepto;
use App\Models\RegistroConcepto;


class ConceptsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $concepts = Concepto::with('tipoConcepto')->get();
        $conceptsTypes = TipoConcepto::all();
        return Inertia::render('Concepts/Index', [
            'concepts' => $concepts,
            'conceptsTypes' => $conceptsTypes
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
        $request->validate([
            'nombreConceptoCorto' => 'required',
            'nombreConceptoLargo' => 'required',
            'precio' => 'required',
            'idTipo' => 'required'
        ]);

        Concepto::create($request->all());
        return redirect()->route('concepts.index');
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
        $registroConcepto = RegistroConcepto::where('idConcepto', $id)->get();
        foreach ($registroConcepto as $registro) {
            $registro->delete();
        }
        $concept = Concepto::find($id);
        $concept->delete();
        return redirect()->route('concepts.index');
    }
}

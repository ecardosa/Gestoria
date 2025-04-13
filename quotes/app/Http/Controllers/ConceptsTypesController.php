<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TipoConcepto;
use App\Models\Concepto;

class ConceptsTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conceptTypes = TipoConcepto::all();
        $user = auth()->user();
        return Inertia::render('ConceptsTypes/Index', [
            'conceptTypes' => $conceptTypes,
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
        $request->validate([
            'nombreTipo' => 'required',
        ]);

        TipoConcepto::create($request->all());

        return redirect()->route('concepts-types.index');
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
        $conceptType = TipoConcepto::find($id);
        $concepts = Concepto::where('idTipo', $id)->get();
        foreach ($concepts as $concept) {
            $concept->idTipo = null;
            $concept->save();
        }


        $conceptType->delete();

        return redirect()->route('concepts-types.index');
    }
}

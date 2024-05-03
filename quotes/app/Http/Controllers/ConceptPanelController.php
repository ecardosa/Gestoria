<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
Use App\Models\Perfil;
Use App\Models\Empresa;
Use App\Models\TipoConcepto;
Use App\Models\Concepto;

class ConceptPanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return concept panel
        return Inertia::render('ConceptPanel');
    }

    public function getConcepts()
    {
        
        // get all concepts with type
        $concepts = Concepto::with('tipoConcepto')->get();
        return response()->json($concepts);

    }

}
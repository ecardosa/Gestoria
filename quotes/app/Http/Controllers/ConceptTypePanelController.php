<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
Use App\Models\Perfil;
Use App\Models\TipoConcepto;


class ConceptTypePanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return profile panel
        return Inertia::render('ConceptTypePanel');
    }

    // get all concept types
    public function getConceptTypes()
    {
        $conceptTypes = TipoConcepto::all();
        return response()->json($conceptTypes);
    }
}

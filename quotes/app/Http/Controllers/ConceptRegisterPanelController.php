<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
Use App\Models\Perfil;
Use App\Models\Empresa;

class ConceptRegisterPanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return concept register panel
        return Inertia::render('ConceptRegisterPanel');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
Use App\Models\Perfil;
Use App\Models\Empresa;

class CompaniesPanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return companies panel
        return Inertia::render('CompaniesPanel');
    }

    // get all companies with the profiles
    public function getCompanies()
    {
        $companies = Empresa::with('perfil')->get();
        return response()->json($companies);
    }

    // get all profiles
    public function getProfiles()
    {
        $profiles = Perfil::get();
        return response()->json($profiles);
    }

    // add company
    public function addCompany()
    {
        $company = new Empresa();
        $company->nomEmpresa = request('nomEmpresa');
        $company->idperfil = request('idperfil');
        $company->save();
    }

  

        
}

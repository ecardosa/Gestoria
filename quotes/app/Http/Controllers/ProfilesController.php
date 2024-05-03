<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Empresa;



class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Perfil::all();
        return Inertia::render('Profiles/Index', [
            'profiles' => $profiles,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Perfil::find($id);
        $users = User::where('idperfil', $id)->get();
        // Make "idperfil" from users and companies "null"
        foreach ($users as $user) {
            $user->idperfil = null;
            $user->save();
        }

        $companies = Empresa::where('idperfil', $id)->get();
        foreach ($companies as $company) {
            $company->idperfil = null;
            $company->save();
        }
        
        $profile->delete();

        return redirect()->route('profiles.index');
    }
}

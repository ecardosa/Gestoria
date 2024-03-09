<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
Use App\Models\Perfil;

class ProfilePanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return profile panel
        return Inertia::render('ProfilePanel');
    }

    public function getProfile()
    {
        $profiles = Perfil::get();      
        return response()->json($profiles);
    }

    public function addProfile()
    {
        $profile = new Perfil();
        $profile->nomPerfil = request('nomPerfil');
        $profile->save();   
    }

    // delete profile and put in the user profileId " "
    public function deleteProfile($id)
    {
        
        $users = User::where('idperfil', $id)->get();
        foreach ($users as $user) {
            $user->idperfil = null;
            $user->save();
        }
        $profile = Perfil::find($id);
        $profile->delete();
    }
    
}

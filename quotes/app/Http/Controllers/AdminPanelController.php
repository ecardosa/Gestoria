<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Perfil;

class AdminPanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        // inertia render return admin panel
        return Inertia::render('AdminPanel');
    }

    public function getAllUsers()
    {
        // get all users with get()
        $users = User::with('perfil')->get();
        return response()->json($users);
    }

    public function deleteUser($id)
    {
        // delete user
        $user = User::find($id);
        $user->delete();
    }
    
    // update user
    public function updateUser($id)
    {
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->idperfil = request('idperfil');
        $user->save();
    }

    public function getProfiles()
    {
        // get all profiles with get()
        $profiles = Perfil::get();
        return response()->json($profiles);
    }

    public function AddUser()
    {
        // add user
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->idperfil = request('idperfil');
        $user->password = bcrypt(request('password'));
        $user->save();
    }
}

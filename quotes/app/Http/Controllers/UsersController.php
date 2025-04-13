<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Perfil;
use App\Models\RegistroEntrada;
use App\Mail\MessageRecived;
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $users = User::with('perfil')->with('registroentrada')->get();
        $admins = User::where('is_admin', 1)->get();
        $notActive = User::where('is_active', 0)->get();
        $profiles = Perfil::all();
     
        return Inertia::render('Users/Index', [
            'users' => $users,
            'profiles' => $profiles,
            'admins' => $admins,
            'notActive' => $notActive,
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
            'name' => 'required',
            'email' => 'required',
            'idperfil' => 'required',
            'password' => 'required',
            'is_admin' => 'required',
            'is_active' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'idperfil' => $request->idperfil,
            'is_admin' => $request->is_admin,
            'is_active' => $request->is_active,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index');
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'idperfil' => 'required',
            'is_admin' => 'required',
            'is_active' => 'required',
        ]);

        $user = User::find($id);
        // v if the is_active was changed to true, send the email, if already was true, do nothing
        if ($request->is_active == 1 && $user->is_active == 0) {
            $user->sendEmailVerificationNotification();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->idperfil = $request->idperfil;
        $user->is_admin = $request->is_admin;
        $user->is_active = $request->is_active;
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}

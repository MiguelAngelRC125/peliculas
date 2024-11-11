<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    
    public function index()
    {
        $usuarios = Usuario::with('estrenos:title')->get();
        return Inertia::render('Usuarios/Index',[
            'usuarios' => $usuarios
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80'
        ]);
        $usuario = new Usuario($request->input());
        $usuario->save();
        return redirect('usuarios');
    }

    public function show(Usuario $usuario)
    {
        //
    }

    public function edit(Usuario $usuario)
    {
        
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80'
        ]);
        $usuario->update($request->input());
        return redirect('usuarios');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect('usuarios');
    }
}

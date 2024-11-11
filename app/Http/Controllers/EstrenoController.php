<?php

namespace App\Http\Controllers;

use App\Models\Estreno;
use Inertia\Inertia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstrenoController extends Controller
{

    public function index()
    {
        return Inertia::render('Estrenos/Index', [
            'estrenos' => Estreno::paginate(10)
        ]);
    }


    public function create()
    {
        return Inertia::render('Estrenos/Create',[
            'usuarios' =>Usuario::all()
        ]);
    }


    public function store(Request $request)
{
    // Validación de los datos de entrada
    $request->validate([
        'isbn' => 'required|max:13',
        'description' => 'required|max:200',
        'title' => 'required|max:100',
        'publisher' => 'required|max:100',
        'release_date' => 'required|date',
        'image' => 'required|file|mimes:png,jpg,gif',
        'usuarios' => 'required|array'
    ]);

    // Crear el registro de estreno con solo los datos necesarios
    $estreno = Estreno::create($request->only(['isbn', 'description', 'title', 'publisher', 'release_date']));

    // Verificar si hay una imagen y si la carga es exitosa
    if ($request->hasFile('image')) {
        $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/img', $imgName);

        // Verificar si el almacenamiento fue exitoso
        if ($path) {
            $estreno->image = '/img/' . $imgName;
            $estreno->save();
        } else {
            return back()->withErrors('Error al guardar la imagen.');
        }
    }
    $estreno->usuarios()->sync($request->usuarios);
    return redirect('estrenos/create')->with('success', 'Estreno creado');
}

public function updateEstreno(Request $request)
{
    // Validación de los datos de entrada
    $request->validate([
        'isbn' => 'required|max:13',
        'description' => 'required|max:200',
        'title' => 'required|max:100',
        'publisher' => 'required|max:100',
        'release_date' => 'required|date',
        'id' => 'required|numeric', // Cambiado a 'numeric'
        'usuarios' => 'required|array'
    ]);

    // Buscar el registro de estreno
    $estreno = Estreno::find($request->id);
    if (!$estreno) {
        return back()->withErrors('El registro de estreno no existe.');
    }

    // Actualizar solo los datos necesarios
    $estreno->update($request->only(['isbn', 'description', 'title', 'publisher', 'release_date']));

    // Procesar nueva imagen si se ha subido
    if ($request->hasFile('image')) {
        // Eliminar la imagen anterior solo si existe
        if ($estreno->image) {
            Storage::disk('public')->delete($estreno->image);
        }

        $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/img', $imgName);

        // Verificar si el almacenamiento fue exitoso
        if ($path) {
            $estreno->image = '/img/' . $imgName;
            $estreno->save();
        } else {
            return back()->withErrors('Error al guardar la imagen.');
        }
    }
    $estreno->usuarios()->sync($request->usuarios);
    return redirect('estrenos')->with('success', 'Estreno actualizado');
}



    public function show(Estreno $estreno)
    {
        return Inertia::render('Estrenos/Show', [
            'estreno' => $estreno,
            'usuarios' => $estreno->usuarios
        ]);
    }


    public function edit(Estreno $estreno)
    {
        return Inertia::render('Estrenos/Edit',[
            'usuarios' =>Usuario::all(),
            'estreno' => $estreno,
            'usuariosOfEstreno' => $estreno->usuarios
        ]);
    }


    public function update(Request $request, Estreno $estreno)
    {
        //
    }


    public function destroy(Estreno $estreno)
    {
        $estreno->delete();
        return redirect('estrenos')->with('success', 'Estreno Eliminado');
    }
}

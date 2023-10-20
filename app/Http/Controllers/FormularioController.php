<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener un modelo llamado Usuario
use Illuminate\Support\Facades\Storage;

class FormularioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('formulario', compact('usuarios'));
    }

    public function store(Request $request)
    {

        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'foto_perfil' => 'image|max:2048', // Ajusta el tamaño máximo según tus necesidades
        ]);

        $respuesta = '¡Formulario enviado con éxito!';

        // Verifica si se proporcionó un ID de usuario
        if ($request->has('id')) {
            // Estás actualizando un usuario existente
            $usuario = User::find($request->input('id'));
            $respuesta = '¡Formulario editado con éxito!';
        } else {
            // Estás creando un nuevo usuario
            $usuario = new User();
        }

        // Actualiza los campos del usuario
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellido');
        $usuario->correo = $request->input('correo');
        $usuario->telefono = $request->input('telefono');
        $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');

        // Verifica si se proporciona una nueva foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $foto_perfil = $request->file('foto_perfil');
            $foto_perfilPath = $foto_perfil->store('fotos_perfil', 'public');
            $usuario->foto_perfil = $foto_perfilPath;
        }

        // Guarda el usuario en la base de datos
        $usuario->save();

        return redirect('/formulario')->with('success', $respuesta);
    }

    public function edit($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect('/formulario')->with('error', '¡No se pudo editar el formulario!');
        }

        return view('formulario-edit', compact('usuario'));
    }

    public function destroy($id)
    {
        // Encuentra al usuario que se va a eliminar
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect('/formulario')->with('error', '¡No se pudo eliminar el formulario!');
        }

        // Elimina la foto de perfil si existe
        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        // Elimina al usuario de la base de datos
        $usuario->delete();

        // Redirige con un mensaje de éxito o cualquier otro comportamiento deseado
        return redirect('/formulario')->with('success', '¡Usuario eliminado con éxito!');
    }
}

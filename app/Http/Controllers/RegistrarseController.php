<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\PythonApiService;

class RegistrarseController extends Controller
{
    protected $pythonApi;

    public function __construct(PythonApiService $pythonApi)
    {
        $this->pythonApi = $pythonApi;
    }

    public function registrarse()
    {
        $user = auth()->guard('usuarios')->user();
        return view('libros.registrarse', compact('user'));
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|min:3',
            'user_tipo' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar que el email no exista ya
        $existe = $this->pythonApi->getUsuarioByEmail($request->email);
        if ($existe['success'] && $existe['data']) {
            return redirect()->back()
                ->withErrors(['email' => 'El email ya está registrado.'])
                ->withInput();
        }

        $response = $this->pythonApi->createUsuario([
            'nombre'     => $request->nombre,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'direccion'  => $request->direccion,
            'telefono'   => $request->telefono,
            'user_tipo'  => $request->user_tipo,
            'puntos'     => 0,
            'tipo_usuario' => 'cliente'
        ]);

        if ($response['success']) {
            return redirect()->back()->with('success', 'Usuario registrado correctamente');
        }

        return redirect()->back()->with('error', 'Error al registrar usuario');
    }
}

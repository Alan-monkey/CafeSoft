<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use App\Services\PythonApiService;

class LoginController extends Controller
{
    protected $pythonApi;

    public function __construct(PythonApiService $pythonApi)
    {
        $this->pythonApi = $pythonApi;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = $this->pythonApi->getUsuarioByEmail($request->email);

        if (!$response['success'] || !$response['data']) {
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])->withInput();
        }

        $userData = $response['data'];

        if (!Hash::check($request->password, $userData['password'])) {
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])->withInput();
        }

        // Crear instancia del modelo para el guard de Laravel
        $user = new Usuarios();
        $user->forceFill($userData);
        $user->exists = true;

        Auth::guard('usuarios')->login($user);

        if ($user->user_tipo == 0) {
            return redirect()->intended('/libros/inicio');
        } else {
            return redirect()->intended('/inicio');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('usuarios')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

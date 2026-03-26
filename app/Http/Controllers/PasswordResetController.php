<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\PythonApiService;

class PasswordResetController extends Controller
{
    protected $pythonApi;

    public function __construct(PythonApiService $pythonApi)
    {
        $this->pythonApi = $pythonApi;
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = $this->pythonApi->getUsuarioByEmail($request->email);

        if (!$response['success'] || !$response['data']) {
            return back()->withErrors(['email' => 'No encontramos un usuario con ese email.']);
        }

        $userData = $response['data'];
        $token = Str::random(64);
        $expiresAt = Carbon::now()->addHours(1)->toDateTimeString();

        $this->pythonApi->updateUsuario($userData['_id'], [
            'reset_token' => $token,
            'reset_token_expires_at' => $expiresAt
        ]);

        $resetUrl = route('password.reset', ['token' => $token]);

        return view('auth.forgot-password', [
            'email'      => $request->email,
            'reset_link' => $resetUrl,
            'show_link'  => true,
            'token'      => $token
        ]);
    }

    public function showResetForm($token)
    {
        $response = $this->pythonApi->getUsuarioByToken($token);

        if (!$response['success'] || !$response['data']) {
            return redirect()->route('password.forgot')
                ->withErrors(['error' => 'El enlace es inválido o ha expirado.']);
        }

        $userData = $response['data'];

        if (!empty($userData['reset_token_expires_at'])) {
            try {
                if (Carbon::parse($userData['reset_token_expires_at'])->isPast()) {
                    return redirect()->route('password.forgot')
                        ->withErrors(['error' => 'El enlace ha expirado.']);
                }
            } catch (\Exception $e) {
                Log::warning('Error al parsear fecha: ' . $e->getMessage());
            }
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $userData['email']
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:3|confirmed',
        ]);

        $response = $this->pythonApi->getUsuarioByToken($request->token);

        if (!$response['success'] || !$response['data']) {
            return back()->withErrors(['error' => 'El token es inválido o ha expirado.'])->withInput();
        }

        $userData = $response['data'];

        if (!empty($userData['reset_token_expires_at'])) {
            try {
                if (Carbon::parse($userData['reset_token_expires_at'])->isPast()) {
                    $this->pythonApi->updateUsuario($userData['_id'], [
                        'reset_token' => null,
                        'reset_token_expires_at' => null
                    ]);
                    return redirect()->route('password.forgot')
                        ->withErrors(['error' => 'El enlace ha expirado. Por favor, solicita uno nuevo.']);
                }
            } catch (\Exception $e) {
                Log::warning('Error al verificar expiración: ' . $e->getMessage());
            }
        }

        $this->pythonApi->updateUsuario($userData['_id'], [
            'password'               => Hash::make($request->password),
            'reset_token'            => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->route('login')->with([
            'success' => '¡Contraseña actualizada correctamente! Ahora puedes iniciar sesión.'
        ]);
    }
}

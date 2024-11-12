<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Tentar autenticar o usuário
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home');  // Redireciona para a página inicial após login bem-sucedido
        }

        // Se falhar, redireciona de volta com uma mensagem de erro
        return back()->withErrors(['email' => 'Usuário inválido.', 'password' => 'Senha inválida.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

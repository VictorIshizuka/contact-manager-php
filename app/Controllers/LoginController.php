<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validation;

class LoginController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $validation = Validation::validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], request()->all());

        if ($validation->isInvalid()) {
            return view('login');
        }

        $user = User::findByEmail(request()->post('email'));

        if (empty($user) || ! password_verify(request()->post('password'), $user->password)) {
            flash()->push('validation_login', ['Usuário ou senha estão incorretos!']);

            return view('login');
        }

        session()->set('auth', $user);

        flash()->push('message', 'Seja bem-vindo, '.$user->name.'!');

        return redirect('notes');
    }
}

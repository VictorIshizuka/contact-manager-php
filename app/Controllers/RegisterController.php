<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validation;

class RegisterController
{
    public function index()
    {
        return view('register');
    }

    public function register()
    {
        $validation = Validation::validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'confirmed', 'unique:users'],
            'password' => ['required', 'min:8', 'max:30', 'strong'],
        ], request()->all());

        if ($validation->isInvalid()) {
            return view('register');
        }

        User::create(request()->all());

        flash()->push('message', 'Registrado com sucesso! 👍');

        return redirect('/login');
    }
}

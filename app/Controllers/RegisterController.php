<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validation;
use Exception;

class RegisterController
{
    public function index()
    {
        return view('auth/register');
    }

    public function register()
    {
        $validation = Validation::validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:30', 'strong', 'confirmed'],
        ], request()->all());

        if (request()->isAjax()) {
            if ($validation->isInvalid()) {
                return json(['success' => false, 'errors' => $validation->errors()], 422);
            }

            User::create(request()->all());

            flash()->push('message', 'Registrado com sucesso!');
            return json(['success' => true, 'redirect' => '/login']);
        }
    }
}

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
        try {

            $validation = Validation::validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'max:30', 'strong', 'confirmed'],
            ], request()->all());

            if ($validation->isInvalid()) {
                return view('auth/register');
            }

            User::create(request()->all());

            flash()->push('message', 'Registrado com sucesso! 👍');

            return redirect('/login');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

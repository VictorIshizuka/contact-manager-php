<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validation;

class LoginController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $validation = Validation::validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], request()->all());

        if (request()->isAjax()) {

            if ($validation->isInvalid('login')) {
                return json(['success' => false, 'errors' => $validation->errors()], 422);
            }

            $user = User::findByEmail(request()->post('email'));

            if (empty($user) || ! password_verify(request()->post('password'), $user->password)) {
                $errorMsg = ['Usuário ou senha estão incorretos!'];
                return json(['success' => false, 'errors' => ['email' => $errorMsg]], 401);
            }

            session()->set('auth', $user);

            return json(['success' => true, 'redirect' => '/contacts']);
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validation;

class SettingController
{
  public function __invoke()
  {
    $password = request()->post('password');

    $validation = Validation::validate([
      'password' => ['required'],
    ], request()->all());

    if ($validation->isInvalid()) {
      return json(['success' => false, 'errors' => $validation->errors()], 422);
    }

    if (! password_verify($password, auth()->password)) {
      return json(['success' => false, 'message' => 'Senha incorreta!'], 403);
    }

    User::delete(auth()->id);

    logout();

    return json(['success' => true]);
  }
}

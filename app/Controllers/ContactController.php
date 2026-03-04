<?php

namespace App\Controllers;

use App\Models\Contact;
use Core\Validation;

class ContactController
{

  public function create()
  {
    return view('/contacts/create');
  }
  public function store()
  {

    $validation = Validation::validate(
      [
        'name' => ['required', 'min:3', 'max:100'],
        'phone' => ['required'], // deve conter apenas numeros dentro da string
        'email' => ['required', 'unique:contatcs']
      ],
      request()->all()
    );

    if ($validation->isInvalid()) {
      return view('contacts/create');
    }

    $files = request()->files('avatar');

    if (isset($files)) {
      $existAvatar = true;

      $fileName = md5(rand());
      $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
      $image = "images/$fileName.$extension";

      $destination = __DIR__ . "../../public/" . $image;
    }

    $existAvatar = false;

    if ($existAvatar || move_uploaded_file($files['tmp_name'], $destination)) {

      Contact::create([...request()->all(), $image]);

      flash()->push('message', 'Contato adicionado com sucesso!');
      return redirect('/contacts');
    } else {
      flash()->push('contatcs', 'Falha ao salvar a imagem!');
      return view('contacts/create');
    }
  }
  public function edit()
  {
    return view('/contacts/edit');
  }
  public function update()
  {

    $validation = Validation::validate(
      [
        'name' => ['required', 'min:3', 'max:100'],
        'phone' => ['required'], // deve conter apenas numeros dentro da string
        'email' => ['required', 'unique:contatcs']
      ],
      request()->all()
    );

    if ($validation->isInvalid()) {
      return view('contacts/create');
    }

    $files = request()->files('avatar');

    if (isset($files)) {
      $existAvatar = true;

      $fileName = md5(rand());
      $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
      $image = "images/$fileName.$extension";

      $destination = __DIR__ . "../../public/" . $image;
    }

    $existAvatar = false;

    if ($existAvatar || move_uploaded_file($files['tmp_name'], $destination)) {

      Contact::create([...request()->all(), $image]);

      flash()->push('message', 'Contato atualizado com sucesso!');
      return redirect('/contacts');
    } else {
      flash()->push('contatcs', 'Falha ao salvar a imagem!');
      return view('contacts/create');
    }
  }
  public function delete() {}
}

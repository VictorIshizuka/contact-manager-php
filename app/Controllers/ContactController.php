<?php

namespace App\Controllers;

use App\Models\Contact;
use Core\Validation;

class ContactController
{
  public function store()
  {

    $validation = Validation::validate([
      'name' => ['required', 'min:3', 'max:100'],
      'phone' => ['required', 'unique:contacts'],
      'email' => ['required', 'email', 'unique:contacts']
    ], request()->all());

    if ($validation->isInvalid()) {
      return json(['success' => false, 'errors' => $validation->errors()], 422);
    }

    $image = 'images/default-avatar.png'; // Fallback
    $file = request()->files('avatar');


    if ($file && $file['tmp_name']) {
      $fileName = md5(uniqid()) . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
      $destination = base_path("public/images/" . $fileName);
      $imagePath = "images/" . $fileName;

      if (move_uploaded_file($file['tmp_name'], $destination)) {
        $image = $imagePath;
      }
    }

    $contactId = Contact::create([
      'name'  => request()->post('name'),
      'phone' => request()->post('phone'),
      'email' => request()->post('email'),
      'avatar' => $image,
      'user_id' => auth()->id
    ]);

    return json([
      'success' => true,
      'message' => 'Contato salvo!',
      'contact' => [
        'name' => request()->post('name'),
        'phone' => request()->post('phone'),
        'email' => request()->post('email'),
        'avatar' => $image,
        'first_letter' => strtoupper(substr(request()->post('name'), 0, 1))
      ]
    ]);
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

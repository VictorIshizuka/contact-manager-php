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
    $id = request()->post('id');

    if (!$id) {
      return json(['success' => false, 'message' => 'ID do contato não encontrado.'], 400);
    }

    $validation = Validation::validate([
      'name' => ['required', 'min:3', 'max:100'],
      // 'phone' => ['required', 'unique:contacts'],
      // 'email' => ['required', 'email', 'unique:contacts']
    ], request()->all());


    if ($validation->isInvalid()) {
      return json(['success' => false, 'errors' => $validation->errors()], 422);
    }

    $image = request()->post('current_avatar');
    $file = request()->files('avatar');


    if ($file && $file['tmp_name']) {
      $fileName = md5(uniqid()) . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
      $destination = base_path("public/images/" . $fileName);
      $imagePath = "images/" . $fileName;

      if (move_uploaded_file($file['tmp_name'], $destination)) {
        $image = $imagePath;
      }
    }

    Contact::update([
      'id'     => $id,
      'name'   => request()->post('name'),
      'phone'  => request()->post('phone'),
      'email'  => request()->post('email'),
      'avatar' => $image
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
  public function destroy()
  {
    $id = request()->post('id');

    if (!$id) {
      return json(['success' => false, 'message' => 'ID não fornecido'], 400);
    }

    Contact::delete($id);

    return json(['success' => true, 'message' => 'Contato excluído com sucesso!']);
  }

  public function show()
  {
    $password = request()->post('password');

    $validation = Validation::validate([
      'password' => ['required'],
    ], request()->all());

    if ($validation->isInvalid()) {
      return json(['success' => false, 'errors' => $validation->errors()], 422);
    }

    if (!password_verify($password, auth()->password)) {
      return json(['success' => false, 'message' => 'Senha incorreta!'], 403);
    }

    session()->set('show_private_data', true);
    return json(['success' => true]);
  }

  public function hidden()
  {
    session()->forget('show_private_data');
    return redirect('/contacts');
  }

  public function revealIndividual()
  {
    $id = request()->post('reveal_id');
    $password = request()->post('password');

    $validation = Validation::validate([
      'password' => ['required'],
    ], request()->all());

    if ($validation->isInvalid()) {
      return json(['success' => false, 'errors' => $validation->errors()], 422);
    }

    if (!password_verify($password, auth()->password)) {
      return json(['success' => false, 'message' => 'Senha incorreta!'], 403);
    }

    $database = new \Core\Database(config('database'));
    $contact = $database->query(
      'SELECT * FROM contacts WHERE id = :id AND user_id = :user_id',
      Contact::class,
      ['id' => $id, 'user_id' => auth()->id]
    )->fetch();

    if (!$contact) {
      return json(['success' => false, 'message' => 'Contato não encontrado.'], 404);
    }

    return json([
      'success' => true,
      'email' => decrypt($contact->email),
      'phone' => decrypt($contact->phone)
    ]);
  }
}

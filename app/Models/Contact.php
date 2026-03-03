<?php

namespace App\Models;

use Carbon\Carbon;
use Core\Database;

class Contact
{
  public $id;

  public $name;

  public $email;

  public $phone;

  public $user_id;

  public $created_at;

  public $updated_at;

  public static function findByEmail($email)
  {
    $database = new Database(config('database'));

    return $database->query(
      'SELECT * FROM contacts WHERE email = :email',
      self::class,
      compact('email')
    )->fetch();
  }

  public static function findByPhone($phone)
  {
    $database = new Database(config('database'));

    return $database->query(
      'SELECT * FROM contacts WHERE email = :email',
      self::class,
      compact('phone')
    )->fetch();
  }

  public static function all($search = null)
  {
    $database = new Database(config('database'));

    return $database->query(
      'SELECT * FROM contacts WHERE user_id = :user_id' . (
        $search ? ' AND name OR email OR phone LIKE :search' : ''
      ),
      self::class,
      array_merge(
        ['user_id' => auth()->id],
        $search ? ['search' => "%$search%"] : []
      )

    )->fetchAll();
  }

  public static function create($data)
  {
    $database = new Database(config('database'));

    return $database->query(
      'INSERT INTO contacts (name, email, password) VALUES (:name, :email, :password)',
      params: [
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'user_id' => $data['user_id'],
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]
    );
  }

  public static function update($data)
  {
    $database = new Database((config('database')));

    $set = 'name = :name';

    if ($data['phone']) {

      $set .= ', phone = :phone';
    }

    if ($data['email']) {

      $set .= ', email = :email';
    }

    return $database->query(
      "UPDATE contacts
            SET $set
            WHERE id = :id",
      params: array_merge(
        [
          'name' => $data['name'],
          'id' => $data['id'],
        ],
        $data['email'] ? ['email' => encrypt($data['email'])] : [],
        $data['phone'] ? ['phone' => encrypt($data['phone'])] : []
      )
    );
  }

  public static function delete($id)
  {
    $database = new Database((config('database')));

    return $database->query('DELETE FROM contacts WHERE id = :id', params: compact('id'));
  }

  public function createdAt()
  {
    return Carbon::parse($this->created_at);
  }

  public function updatedAt()
  {
    return Carbon::parse($this->updated_at);
  }
}

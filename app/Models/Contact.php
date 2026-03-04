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

  public $avatar;

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
      'INSERT INTO contacts (name, email, phone, user_id, avatar, created_at, updated_at)
        VALUES (:name, :email, :phone, :user_id, :avatar, :created_at, :updated_at)',
      params: [
        'name'       => $data['name'],
        'email'      => $data['email'],
        'phone'      => $data['phone'],
        'user_id'    => $data['user_id'],
        'avatar'     => $data['avatar'],
        'created_at' => Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon::now()->toDateTimeString(),
      ]
    );
  }

  public static function update($data)
  {
    $database = new Database((config('database')));

    $set = 'name = :name, updated_at = :updated_at';

    $params = [
      'id' => $data['id'],
      'name' => $data['name'],
      'updated_at' => Carbon::now()->toDateTimeString()
    ];

    // Adição condicional de campos
    if (!empty($data['phone'])) {
      $set .= ', phone = :phone';
      $params['phone'] = $data['phone'];
    }

    if (!empty($data['email'])) {
      $set .= ', email = :email';
      $params['email'] = $data['email'];
    }

    if (!empty($data['avatar'])) {
      $set .= ', avatar = :avatar';
      $params['avatar'] = $data['avatar'];
    }

    return $database->query(
      "UPDATE contacts
            SET $set
            WHERE id = :id",
      params: $params
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

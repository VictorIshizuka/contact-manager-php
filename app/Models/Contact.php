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

  public function email()
  {
    if (session()->get('show_private_data')) {
      return decrypt($this->email);
    }
    return "••••••••@••••.com";
  }

  public function phone()
  {
    if (session()->get('show_private_data')) {
      return decrypt($this->phone);
    }
    return "(••) •••••-••••";
  }

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

  public static function all($search = null, $letter = null)
  {
    $database = new Database(config('database'));
    $query = 'SELECT * FROM contacts WHERE user_id = :user_id';
    $params = ['user_id' => auth()->id];

    if ($search) {
      $query .= ' AND (name LIKE :search OR email LIKE :search OR phone LIKE :search)';
      $params['search'] = "%$search%";
    }

    if ($letter) {
      $query .= ' AND name LIKE :letter';
      $params['letter'] = "$letter%";
    }

    $query .= ' ORDER BY name ASC';

    return $database->query($query, self::class, $params)->fetchAll();
  }

  public static function create($data)
  {
    $database = new Database(config('database'));

    return $database->query(
      'INSERT INTO contacts (name, email, phone, user_id, avatar, created_at, updated_at)
        VALUES (:name, :email, :phone, :user_id, :avatar, :created_at, :updated_at)',
      params: [
        'name'       => $data['name'],
        'email'      => encrypt($data['email']),
        'phone'      => encrypt($data['phone']),
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
      $params['phone'] = encrypt($data['phone']);
    }

    if (!empty($data['email'])) {
      $set .= ', email = :email';
      $params['email'] = encrypt($data['email']);
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

  public function toArray()
  {
    $show = session()->get('show_private_data');
    return [
      'id' => $this->id,
      'name' => $this->name,
      // Só envia o dado real para o JS se a sessão permitir
      'phone' => $show ? decrypt($this->phone) : "(••) •••••-••••",
      'email' => $show ? decrypt($this->email) : "••••••••@••••.com",
      'is_decrypted' => $show,
      'avatar' => $this->avatar
    ];
  }
}

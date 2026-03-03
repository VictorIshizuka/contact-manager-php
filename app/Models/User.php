<?php

namespace App\Models;

use Core\Database;

class User
{
    public $id;

    public $name;

    public $email;

    public $password;

    public static function findByEmail($email)
    {
        $database = new Database(config('database'));

        return $database->query(
            'SELECT * FROM users WHERE email = :email',
            self::class,
            ['email' => $email]
        )->fetch();
    }

    public static function create($data)
    {
        $database = new Database(config('database'));

        return $database->query(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)',
            params: [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]
        );
    }
}

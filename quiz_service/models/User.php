<?php

class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $avatar;
    public $created_at;
    public $updated_at;

    public static function findByEmail($email) {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $stmt->fetch();
    }

    public static function create($name, $email, $password, $avatar = null) {
        $db = DB::getInstance();
        $stmt = $db->prepare("INSERT INTO users (name, email, password, avatar) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $avatar]);
    }
}

<?php

class Quiz {
    public $id;
    public $category_id;
    public $title;
    public $description;
    public $created_at;
    public $updated_at;

    public static function all() {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT * FROM quizzes");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Quiz');
        return $stmt->fetchAll();
    }

    public static function find($id) {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Quiz');
        return $stmt->fetch();
    }

    public static function create($category_id, $title, $description) {
        $db = DB::getInstance();
        $stmt = $db->prepare("INSERT INTO quizzes (category_id, title, description) VALUES (?, ?, ?)");
        return $stmt->execute([$category_id, $title, $description]);
    }
}

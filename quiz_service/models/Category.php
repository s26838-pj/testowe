<?php

class Category {
    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public static function all() {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT * FROM categories");
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
        return $stmt->fetchAll();
    }
}

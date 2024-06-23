<?php

class DB {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=quiz_service', 'root', '');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}

spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/models/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    } elseif (file_exists(__DIR__ . '/controllers/' . $class_name . '.php')) {
        require_once __DIR__ . '/controllers/' . $class_name . '.php';
    }
});
?>

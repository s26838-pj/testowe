<?php

class ProfileController {
    public function index() {
        // Sprawdzenie, czy użytkownik jest zalogowany
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit();
        }
        
        // Wczytanie widoku profilu
        include '../views/profile.php';
    }
}
?>

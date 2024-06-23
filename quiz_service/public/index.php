<?php
session_start();

// Sprawdź, czy użytkownik nie jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Przekierowanie do strony logowania
    exit();
} else {
    header('Location: dashboard.php'); // Przekierowanie do dashboardu
    exit();
}
// Router
$url = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : '/';

switch ($url) {
    case '/':
        // Przekierowanie na stronę główną aplikacji po zalogowaniu
        header('Location: /dashboard');
        exit();
    case '/login':
        // Obsługa logowania
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once '../views/users/login.php'; // Poprawiona ścieżka do widoku logowania
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obsługa logowania użytkownika (logika logowania)
            require_once '../controllers/UserController.php';
            $controller = new UserController();
            $controller->login();
        }
        break;
    case '/profile':
        $controller = new UserController();
        $controller->showProfile();
        break;
    case '/register':
        // Obsługa rejestracji
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once '../views/users/register.php'; // Poprawiona ścieżka do widoku rejestracji
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obsługa rejestracji użytkownika (logika rejestracji)
            require_once '../controllers/UserController.php';
            $controller = new UserController();
            $controller->register();
        }
        break;
    case '/dashboard':
        // Strona główna aplikacji po zalogowaniu
        require_once '../views/dashboard.php'; // Poprawiona ścieżka do widoku dashboard
        break;
    default:
        // Obsługa innych ścieżek (np. 404)
        echo 'Error 404: Page not found';
        break;
}
?>

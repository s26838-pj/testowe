<?php

class UserController {
    
    public function showLoginForm() {
        require '../public/login.php';
    }
    
    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if ($this->authenticate($email, $password)) {
            header('Location: /quiz_service/public/dashboard.php');
            exit();
        } else {
            header('Location: /quiz_service/public/login.php');
            exit();
        }
    }
    
    
    public function showProfile() {
        
    require '../public/profile.php';
    }

    
    public function showRegisterForm() {
        require '../public/register.php';
    }
    
    public function register() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $db = DB::getInstance();
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        
        header('Location: /quiz_service/public/login.php');
        exit();
    }
    
    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
    
    private function authenticate($email, $password) {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        } else {
            return false;
        }
    }
}
?>

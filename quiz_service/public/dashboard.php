<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    <nav>
        <ul>
            <li><a href="/quiz_service/public/quizzes/index.php">Take a Quiz</a></li>
            <li><a href="/quiz_service/public/profile.php">View Profile</a></li>
            <li><a href="/quiz_service/public/logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>

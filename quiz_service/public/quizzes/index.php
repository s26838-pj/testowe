<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}

// Połączenie z bazą danych
require '../../config.php';

// Pobranie listy quizów z bazy danych
try {
    $db = DB::getInstance();
    $stmt = $db->query("SELECT * FROM quizzes");
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Obsługa błędów połączenia z bazą danych
    echo 'Database error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz List</title>
    <link rel="stylesheet" href="/quiz_service/public/css/style.css">
    <style>
        /* Dodatkowe style dla strony z listą quizów */
        .quiz-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .quiz-card h3 {
            margin-top: 0;
        }
        .quiz-card p {
            margin-bottom: 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Quiz List</h1>
    <div class="quiz-list">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-card">
                <h3><?= $quiz['title']; ?></h3>
                <p><?= $quiz['description']; ?></p>
                <a href="solve_quiz.php?quiz_id=<?= $quiz['id']; ?>" class="btn btn-primary">Solve Quiz</a>
            </div>
        <?php endforeach; ?>
        <a href="create.php" class="btn btn-primary">Create Quiz</a>
    </div>
</body>
</html>

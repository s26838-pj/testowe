<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}

// Sprawdzenie, czy przekazano quiz_id w parametrze URL
if (!isset($_GET['quiz_id'])) {
    header('Location: /quiz_service/public/quizzes/index.php');
    exit();
}

$quiz_id = $_GET['quiz_id'];

// Połączenie z bazą danych
require '../../config.php';

try {
    $db = DB::getInstance(); // Uzyskanie instancji połączenia z bazą danych

    // Pobranie quizu
    $stmt = $db->prepare("SELECT * FROM quizzes WHERE id = ?");
    $stmt->execute([$quiz_id]);
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    // Pobranie pytań z quizu wraz z odpowiedziami
    $stmt = $db->prepare("SELECT q.id AS question_id, q.text AS question_text, a.id AS answer_id, a.text AS answer_text
                          FROM questions q
                          LEFT JOIN answers a ON q.id = a.question_id
                          WHERE q.quiz_id = ?
                          ORDER BY q.id, a.id");
    $stmt->execute([$quiz_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Solve Quiz</title>
    <link rel="stylesheet" href="/quiz_service/public/css/style.css">
</head>
<body>
    <h1>Solve Quiz</h1>
    <h2><?= $quiz['title'] ?></h2>
    <p><?= $quiz['description'] ?></p>

    <form action="/quiz_service/public/quizzes/submit_quiz.php" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
        
        <?php foreach ($questions as $key => $question): ?>
            <?php if ($key % 3 === 0): ?>
                <div class="question">
                    <p><?= $question['question_text'] ?></p>
            <?php endif; ?>
            <?php if ($question['answer_id']): ?>
                <label>
                    <input type="radio" name="answers[<?= $question['question_id'] ?>]" value="<?= $question['answer_id'] ?>">
                    <?= $question['answer_text'] ?>
                </label>
            <?php endif; ?>
            <?php if (($key + 1) % 3 === 0 || $key + 1 === count($questions)): ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <button type="submit">Submit Quiz</button>
    </form>
</body>
</html>

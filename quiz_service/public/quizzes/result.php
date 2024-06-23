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
    $stmt = $db->prepare("SELECT q.id AS question_id, q.text AS question_text, a.id AS answer_id, a.text AS answer_text, a.is_correct AS correct_answer
                          FROM questions q
                          LEFT JOIN answers a ON q.id = a.question_id
                          WHERE q.quiz_id = ?
                          ORDER BY q.id, a.id");
    $stmt->execute([$quiz_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pobranie odpowiedzi użytkownika na pytania z quizu
    $stmt = $db->prepare("SELECT ua.question_id, ua.answer_id, a.text AS user_answer_text, a.is_correct AS correct_answer
                          FROM user_answers ua
                          LEFT JOIN answers a ON ua.answer_id = a.id
                          WHERE ua.quiz_id = ? AND ua.user_id = ?");
    $stmt->execute([$quiz_id, $_SESSION['user_id']]);
    $user_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Zmapowanie odpowiedzi użytkownika do tablicy dla łatwiejszego dostępu
    $user_answers_map = [];
    foreach ($user_answers as $answer) {
        $user_answers_map[$answer['question_id']] = [
            'answer_id' => $answer['answer_id'],
            'user_answer_text' => $answer['user_answer_text'],
            'correct_answer' => $answer['correct_answer']
        ];
    }

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="/quiz_service/public/css/style.css">
</head>
<body>
    <h1>Quiz Result</h1>
    <h2><?= $quiz['title'] ?></h2>
    <p><?= $quiz['description'] ?></p>

    <div class="quiz-questions">
        <?php foreach ($questions as $question): ?>
            <div class="question">
                <p><?= $question['question_text'] ?></p>
                <?php if (isset($user_answers_map[$question['question_id']])): ?>
                    <p>Your answer: <?= $user_answers_map[$question['question_id']]['user_answer_text'] ?></p>
                    <?php if ($user_answers_map[$question['question_id']]['correct_answer'] == 1): ?>
                        <p><strong>Correct answer!</strong></p>
                    <?php else: ?>
                        <p><strong>Incorrect answer!</strong></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p><em>No answer submitted.</em></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="/quiz_service/public/quizzes/index.php">Back to Quizzes</a>
</body>
</html>

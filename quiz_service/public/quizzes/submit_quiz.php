<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}

// Sprawdzenie, czy przekazano dane formularza POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    // Pobranie danych z formularza
    $quiz_id = $_POST['quiz_id'];
    $answers = $_POST['answers']; // Tablica z odpowiedziami: ['question_id' => 'answer_id']

    // Połączenie z bazą danych
    require '../../config.php';

    try {
        $db = DB::getInstance(); // Uzyskanie instancji połączenia z bazą danych

        // Rozpoczęcie transakcji
        $db->beginTransaction();

        // Zapisywanie odpowiedzi użytkownika do tabeli user_answers
        foreach ($answers as $question_id => $answer_id) {
            $stmt = $db->prepare("INSERT INTO user_answers (user_id, quiz_id, question_id, answer_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $quiz_id, $question_id, $answer_id]);
        }

        // Zakończenie transakcji
        $db->commit();

        // Przekierowanie po pomyślnym zapisie
        $_SESSION['quiz_submitted'] = true;
        header('Location: /quiz_service/public/quizzes/result.php?quiz_id=' . $quiz_id);
        exit();
    } catch (PDOException $e) {
        // Obsługa błędów zapisu do bazy danych
        $db->rollBack();
        echo 'Database error: ' . $e->getMessage();
        exit();
    }
} else {
    // Przekierowanie w przypadku nieprawidłowego żądania (powinno być POST)
    header('Location: /quiz_service/public/quizzes/index.php');
    exit();
}
?>

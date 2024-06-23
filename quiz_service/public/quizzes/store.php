<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}

// Sprawdzenie, czy dane z formularza zostały przesłane
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobranie danych z formularza
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $number_of_questions = $_POST['number_of_questions'];

    // Przygotowanie tablicy na pytania
    $questions = [];
    for ($i = 1; $i <= $number_of_questions; $i++) {
        $question = [
            'question' => isset($_POST['questions'][$i - 1]) ? $_POST['questions'][$i - 1] : '',
            'description' => isset($_POST['descriptions'][$i - 1]) ? $_POST['descriptions'][$i - 1] : '',
            'num_answers' => isset($_POST['num_answers'][$i - 1]) ? $_POST['num_answers'][$i - 1] : 0,
            'answers' => isset($_POST['answers'][$i - 1]) ? $_POST['answers'][$i - 1] : [],
            'correct_answer' => isset($_POST['correct'][$i - 1]) ? $_POST['correct'][$i - 1] : null
        ];
        $questions[] = $question;
    }

    try {
        // Połączenie z bazą danych
        require '../../config.php';
        $db = DB::getInstance();
        $db->beginTransaction();

        // Zapisywanie quizu do bazy danych
        $stmt = $db->prepare("INSERT INTO quizzes (category_id, title, description) VALUES (?, ?, ?)");
        $stmt->execute([$category_id, $title, $description]);
        $quiz_id = $db->lastInsertId();

        // Zapisywanie pytań i odpowiedzi do bazy danych
        foreach ($questions as $question) {
            // Zapis pytania do tabeli questions
            $stmt = $db->prepare("INSERT INTO questions (quiz_id, text) VALUES (?, ?)");
            $stmt->execute([$quiz_id, $question['question']]);
            $question_id = $db->lastInsertId();

            // Zapis odpowiedzi do tabeli answers
            foreach ($question['answers'] as $index => $answer) {
                $is_correct = ($index + 1 == $question['correct_answer']) ? 1 : 0;
                $stmt = $db->prepare("INSERT INTO answers (question_id, text, is_correct) VALUES (?, ?, ?)");
                $stmt->execute([$question_id, $answer, $is_correct]);
            }
        }

        $db->commit();

        // Przekierowanie do strony potwierdzenia sukcesu
        header('Location: /quiz_service/public/quizzes/success.php');
        exit();
    } catch (PDOException $e) {
        // Obsługa błędów zapisu do bazy danych
        $db->rollBack();
        echo 'Database error: ' . $e->getMessage();
        exit();
    }
} else {
    // Przekierowanie w przypadku nieprawidłowego żądania (powinno być POST)
    header('Location: /quiz_service/public/quizzes/create.php');
    exit();
}
?>

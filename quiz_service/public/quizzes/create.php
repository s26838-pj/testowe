<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: /quiz_service/public/login.php');
    exit();
}

// Połączenie z bazą danych
require '../../config.php'; // Poprawiona ścieżka do config.php

// Pobranie listy kategorii z bazy danych
try {
    $db = DB::getInstance();
    $stmt = $db->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
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
    <title>Create Quiz</title>
    <link rel="stylesheet" href="/quiz_service/public/css/style.css">
    <script src="/quiz_service/public/js/scripts.js" defer></script>
</head>
<body>
    <h1>Create Quiz</h1>
    <form action="/quiz_service/public/quizzes/store.php" method="post">
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= $category->name ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br>
        <label for="number_of_questions">Number of questions:</label>
        <input type="number" id="number_of_questions" name="number_of_questions" min="1" max="10" required><br>

        <!-- Automatyczne pola dla pytań -->
        <div id="questions-container">
            <!-- JS będzie dynamicznie dodawać pola na pytania w zależności od wybranej liczby -->
        </div>

        <button type="submit">Create</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionCountInput = document.querySelector('#number_of_questions');
            const questionsContainer = document.querySelector('#questions-container');

            questionCountInput.addEventListener('change', function() {
                const questionCount = parseInt(this.value);

                // Czyszczenie poprzednich pól
                questionsContainer.innerHTML = '';

                for (let i = 1; i <= questionCount; i++) {
                    const questionDiv = document.createElement('div');
                    questionDiv.innerHTML = `
                        <h3>Question ${i}</h3>
                        <label for="question_${i}">Question:</label>
                        <textarea id="question_${i}" name="questions[]" required></textarea><br>
                        <label for="description_${i}">Description:</label>
                        <textarea id="description_${i}" name="descriptions[]"></textarea><br>
                        <label for="num_answers_${i}">Number of answers:</label>
                        <select id="num_answers_${i}" name="num_answers[]">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select><br>
                        <div id="answers_${i}">
                            <!-- JavaScript będzie generować odpowiedzi dla każdego pytania -->
                        </div>
                    `;
                    questionsContainer.appendChild(questionDiv);

                    // Generowanie pól odpowiedzi dla danego pytania
                    generateAnswerFields(i);
                }
            });

            function generateAnswerFields(questionNumber) {
                const numAnswersSelect = document.querySelector(`#num_answers_${questionNumber}`);
                const answersContainer = document.querySelector(`#answers_${questionNumber}`);

                numAnswersSelect.addEventListener('change', function() {
                    const numAnswers = parseInt(this.value);

                    // Czyszczenie poprzednich pól
                    answersContainer.innerHTML = '';

                    for (let j = 1; j <= numAnswers; j++) {
                        const answerDiv = document.createElement('div');
                        answerDiv.innerHTML = `
                            <label for="answer_${questionNumber}_${j}">Answer ${j}:</label>
                            <input type="text" id="answer_${questionNumber}_${j}" name="answers[${questionNumber - 1}][]" required>
                            <input type="radio" id="correct_${questionNumber}_${j}" name="correct[${questionNumber - 1}]" value="${j}">
                            <label for="correct_${questionNumber}_${j}">Correct</label><br>
                        `;
                        answersContainer.appendChild(answerDiv);
                    }
                });
            }
        });
    </script>
</body>
</html>

<?php

class QuizController {
    public function index() {
        $quizzes = Quiz::all();
        include $_SERVER['DOCUMENT_ROOT'] . '/quiz_service/views/quizzes/index.php';

    }

    public function show($id) {
        $quiz = Quiz::find($id);
        include 'views/quizzes/show.php';
    }

    public function create() {
        $categories = Category::all();
        include 'views/quizzes/create.php';
    }

    public function store() {
        $category_id = $_POST['category_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        Quiz::create($category_id, $title, $description);
        header('Location: /quizzes');
    }
}

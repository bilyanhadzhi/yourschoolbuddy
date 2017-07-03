<?php
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');
  require_once(SRC_DIR . '/domain_objects/exam.php');

  $router = new Router;

  if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $subject_id = $_POST['subject_id'] ?? null;
  $type_id = $_POST['type_id'] ?? null;
  $grade = $_POST['grade'] ?? null;


  $exams_dm = new ExamsDM;
  $exam = new Exam;

  $exam->construct($subject_id, $_POST['student_id'], $type_id, $_POST['exam_date'], $grade);

  $validation_errors = $exam->validate_create();

  if ($validation_errors) {
    $router->redirect_to('/', $validation_errors, Router::$FLASH_RED);
    exit;
  }

  $exams_dm->add($exam);

  $router->redirect_to('/', ['Exam was added successfully!'], Router::$FLASH_GREEN);
  exit;
?>

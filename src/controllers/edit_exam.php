<?php
  require_once(SRC_DIR . '/routing/router.php');
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');

  $title = 'Edit exam';
  $messages = $_SESSION['messages'] ?? null;

  if ($messages) {
    unset($_SESSION['messages']);
  }

  $exams_dm = new ExamsDM;
  $router = new Router;

  if (!isset($params)) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $router->redirect_to('/');
      exit;
    }

    $exam = $exams_dm->get_by_id($_POST['exam_id'], false);

    $exam->set_subject_id($_POST['subject_id']);
    $exam->set_type_id($_POST['type_id']);
    $exam->set_date($_POST['exam_date']);
    $exam->set_grade($_POST['grade'] ?? null);

    $validation_errors = $exam->validate_create();

    if ($validation_errors) {
      $router->redirect_to('/edit_exam/' . $_POST['exam_id'], $validation_errors);
      exit;
    }

    $exams_dm->edit($exam);

    $router->redirect_to('/', ['Exam was edited successfully!'], Router::$FLASH_BLUE);
    exit;
  }

  $exam = $exams_dm->get_by_id($params['exam_id']);

  if (!$exam) {
    http_response_code(404);
    $messages[] = 'Exam does not exist';
  } else {
    $subjects = $exams_dm->get_subjects();
    $exam_types = $exams_dm->get_exam_types();
    $grades = $exams_dm->get_grades();

    if ($exam->student_id !== $_SESSION['student_id']) {
      $router->redirect_to('/', ['You can\'t edit other users\' exams.'], Router::$FLASH_RED);
      exit;
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

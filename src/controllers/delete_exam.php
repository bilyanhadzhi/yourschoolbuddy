<?php
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $exams_dm = new ExamsDM;
  $exam = $exams_dm->get_by_id($_POST['exam_id'], false);

  $validation_errors = $exam->validate_delete();

  if ($validation_errors) {
    $router->redirect_to('/', $validation_errors, Router::$FLASH_RED);
    exit;
  }

  $exams_dm->delete($exam->id);

  $router->redirect_to('/', ['Exam was deleted successfully!'], Router::$FLASH_GREEN);
  exit;
?>

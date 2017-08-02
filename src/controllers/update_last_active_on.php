<?php
  require_once(SRC_DIR . '/data_mappers/students.dm.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $students_dm = new StudentsDM;
  $students_dm->update_last_active_on($_SESSION['student_id']);

  echo 'OK';
?>

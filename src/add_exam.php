<?php require_once(SRC_DIR . '/database/database.php') ?>

<?php
  $is_post = $_SERVER['REQUEST_METHOD'] === 'POST';

  if (!$is_post) {
    $router = new Router;
    $router->redirect_to('/');
    exit;
  }

  $db = new Database;
  $db->add_exam($_POST['subject_id'], $_POST['student_id'], $_POST['type'], $_POST['date'], 'NULL');
?>

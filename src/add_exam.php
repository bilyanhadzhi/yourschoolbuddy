<?php require_once(SRC_DIR . '/database/database.php') ?>
<?php require_once(SRC_DIR . '/forms/add_exam_form.php') ?>

<?php
  $router = new Router;

  if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $subject_id = isset($_POST['subject-id']) ? $_POST['subject-id'] : null;
  $exam_type = isset($_POST['exam-type']) ? $_POST['exam-type'] : null;

  $add_exam_form = new AddExamForm($subject_id, $_POST['student-id'], $exam_type, $_POST['exam-date'],
                                   'NULL');

  if (!$add_exam_form->is_valid()) {
    $router->redirect_to('/', $add_exam_form->get_errors(), $router->flash_classes['RED']);
    exit;
  }

  $db = new Database;
  $db->add_exam($_POST['subject-id'], $_POST['student-id'], $_POST['exam-type'],
                $_POST['exam-date'], 'NULL');

  $router->redirect_to('/', ['Exam was added successfully!'], $router->flash_classes['GREEN']);
?>

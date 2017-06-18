<?php require_once(SRC_DIR . '/database/database.php') ?>
<?php require_once(SRC_DIR . '/forms/add_exam_form.php') ?>

<?php
  $is_post = $_SERVER['REQUEST_METHOD'] === 'POST';
  $router = new Router;

  if (!$is_post) {
    $router->redirect_to('/');
    exit;
  }

  $add_exam_form = new AddExamForm(isset($_POST['subject-id']) ? $_POST['subject-id'] : null,
                                   $_POST['student-id'],
                                   isset($_POST['exam-type']) ? $_POST['exam-type'] : null,
                                   $_POST['exam-date'],
                                   'NULL');


  if (!$add_exam_form->is_valid()) {
    $router->redirect_to_with_data('/', $add_exam_form->get_errors());
    exit;
  }

  $db = new Database;
  $db->add_exam($_POST['subject-id'], $_POST['student-id'], $_POST['exam-type'],
                $_POST['exam-date'], 'NULL');

  $router->redirect_to_with_data('/', ['message' => 'Successfully added exam!']);
?>

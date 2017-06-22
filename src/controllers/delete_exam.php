<?php require_once(SRC_DIR . '/database/database.php') ?>
<?php require_once(SRC_DIR . '/forms/delete_exam_form.php') ?>

<?php
  $is_post = $_SERVER['REQUEST_METHOD'] === 'POST';
  $router = new Router;

  if (!$is_post) {
    $router->redirect_to('/');
    exit;
  }

  $delete_exam_form = new DeleteExamForm(
    isset($_POST['exam_id']) ? $_POST['exam_id'] : null,
    isset($_POST['student_id']) ? $_POST['student_id'] : null,
    isset($_POST['current_user_id']) ? $_POST['current_user_id'] : null
  );

  if (!$delete_exam_form->is_valid()) {
    $router->redirect_to('/', $delete_exam_form->get_errors(), $router->get_flash_class('RED'));
    exit;
  }

  $db = new Database;
  $db->delete_exam($_POST['exam_id']);

  $router->redirect_to('/', ['Exam was deleted successfully!'], $router->get_flash_class('GREEN'));
?>

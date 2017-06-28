<?php require_once(SRC_DIR . '/forms/delete_exam_form.php') ?>
<?php require_once(SRC_DIR . '/data_mappers/exams.dm.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam.php') ?>

<?php
  $router = new Router;

  if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $router->redirect_to('/');
    exit;
  }

  $exam = new Exam;

  $delete_exam_form = new DeleteExamForm($_POST['exam_id'], $_POST['student_id'],
                                         $_SESSION['student_id']);


  if (!$delete_exam_form->is_valid()) {
    $router->redirect_to('/', $delete_exam_form->get_errors(), $router->get_flash_class('RED'));
    exit;
  }

  $exams_dm = new ExamsDM;

  $exams_dm->delete($_POST['exam_id']);

  $router->redirect_to('/', ['Exam was deleted successfully!'], $router->get_flash_class('GREEN'));
?>

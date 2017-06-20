<?php require_once(SRC_DIR . '/database/database.php') ?>
<?php require_once(SRC_DIR . '/routing/router.php') ?>
<?php require_once(SRC_DIR . '/forms/add_exam_form.php') ?>

<?php
  $title = 'Edit exam';
  $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : null;

  if ($messages) {
    unset($_SESSION['messages']);
  }

  $db = new Database;
  $router = new Router;

  if (!isset($params)) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $router->redirect_to('/');
      exit;
    }

    $subject_id = isset($_POST['subject-id']) ? $_POST['subject-id'] : null;
    $exam_type = isset($_POST['exam-type']) ? $_POST['exam-type'] : null;

    $edit_exam_form = new AddExamForm($subject_id, $_POST['student-id'], $exam_type, $_POST['exam-date'],
                                      'NULL');

    if (!$edit_exam_form->is_valid()) {
      $router->redirect_to('/edit_exam/' . $_POST['exam-id'], $edit_exam_form->get_errors());
      exit;
    }

    $db->edit_exam($_POST['exam-id'], $_POST['subject-id'], $_POST['exam-type'], $_POST['exam-date'],
                   'NULL');
    $router->redirect_to('/', ['Exam was edited successfully!'], $router->get_flash_class('BLUE'));
    exit;
  }

  $exam = $db->get_exam_by_id($params['exam_id']);

  if (!$exam) {
    http_response_code(404);
    $messages[] = 'Exam does not exist';
  } else {
    $user = $db->get_current_user();
    $subjects = $db->get_subjects();
    $exam_types = $db->get_exam_types();

    if ($exam->student_id !== $user->id) {
      $router->redirect_to('/', ['You can\'t edit other users\' exams.'], $router->get_flash_class('RED'));
      exit;
    }
  }
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

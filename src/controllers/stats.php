<?php
  require_once(SRC_DIR . '/routing/router.php');
  require_once(SRC_DIR . '/data_mappers/students.dm.php');
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');
  require_once(SRC_DIR . '/data_mappers/stats.dm.php');

  $title = 'Stats';
  $messages = $_SESSION['messages'] ?? null;
  $messages_class = $_SESSION['messages_class'] ?? null;
  $today = date("Y-m-d");

  if ($messages) {
    unset($_SESSION['messages']);

    if ($messages_class) {
      unset($_SESSION['messages_class']);
    }
  }

  $students_dm = new StudentsDM;
  $exams_dm = new ExamsDM;

  $student = $students_dm->get_by_id($params['student_id']);
  $logged_in_student = $students_dm->get_by_id($_SESSION['student_id']);

  $exams = $exams_dm->get_for_student($_SESSION['student_id']);
  $grades = $exams_dm->get_grades();
  $subjects = $exams_dm->get_subjects();
  $exam_types = $exams_dm->get_exam_types();

  if (!$student) {
    $this->page_not_found();
    exit;
  } elseif ($student->id !== $logged_in_student->id) {
    $router = new Router;

    $router->redirect_to('/stats/' . $_SESSION['student_id'],
                         ['You can only see your stats'], Router::$FLASH_RED);
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

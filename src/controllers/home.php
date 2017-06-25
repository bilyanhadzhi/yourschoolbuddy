<?php
  require_once(SRC_DIR . '/data_mappers/students.dm.php');
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');

  $title = 'Exams';
  $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : null;
  $messages_class = isset($_SESSION['messages_class']) ? $_SESSION['messages_class'] : null;
  $today = date("Y-m-d");

  if ($messages) {
    unset($_SESSION['messages']);

    if ($messages_class) {
      unset($_SESSION['messages_class']);
    }
  }

  $students_dm = new StudentsDM;
  $exams_dm = new ExamsDM;

  $user = $students_dm->get_by_id($_SESSION['user_id']);
  // $user = $db->get_current_user();
  // $exams = $db->get_exams_for_student($user->id);
  // $grades = $db->get_grades();

  // $subjects = $db->get_subjects();
  // $exam_types = $db->get_exam_types();
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

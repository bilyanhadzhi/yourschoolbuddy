<?php
  require_once(SRC_DIR . '/data_mappers/students.dm.php');
  require_once(SRC_DIR . '/data_mappers/exams.dm.php');

  $title = 'Exams';
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

  $student = $students_dm->get_by_id($_SESSION['student_id']);

  $exams = $exams_dm->get_for_student($_SESSION['student_id']);
  $grades = $exams_dm->get_grades();
  $subjects = $exams_dm->get_subjects();
  $exam_types = $exams_dm->get_exam_types();
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

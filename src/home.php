<?php
  $title = 'Exams';
  $flash = isset($_SESSION['data']) ? $_SESSION['data'] : null;
  $today = date("Y-m-d");

  if ($flash) {
    unset($_SESSION['data']);
  }

  $db = new Database;
  $user = $db->get_current_user();
  $exams = $db->get_exams_by_student_id($user->id);

  $subjects = $db->get_subjects();
  $exam_types = $db->get_exam_types();
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

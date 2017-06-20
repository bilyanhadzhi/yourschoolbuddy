<?php
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

  $db = new Database;
  $user = $db->get_current_user();
  $exams = $db->get_exams_by_student_id($user->id);

  $subjects = $db->get_subjects();
  $exam_types = $db->get_exam_types();
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

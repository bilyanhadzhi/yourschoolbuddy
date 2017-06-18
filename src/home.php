<?php
  $title = 'Exams';
  $flash = isset($_SESSION['data']) ? $_SESSION['data'] : null;
  $today = date("Y-m-d");

  if ($flash) {
    unset($_SESSION['data']);
  }

  $db = new Database;
  $user = $db->get_current_user();
  $subjects = $db->get_subjects();
  $exams = $db->get_exams_by_student_id($user->id);

  $types = [
    ['value' => 'multiple_choice', 'name' => 'Multiple choice'],
    ['value' => 'oral', 'name' => 'Oral'],
  ];
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

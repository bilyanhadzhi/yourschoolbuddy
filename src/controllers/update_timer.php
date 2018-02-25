<?php
  require_once(SRC_DIR . '/data_mappers/timers.dm.php');
  require_once(SRC_DIR . '/domain_objects/timer.php');
  require_once(SRC_DIR . '/routing/router.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $timers_dm = new TimersDM;

  $current_timer = $timers_dm->get_for_student($_SESSION['student_id']);

  $new_timer = new Timer;

  $new_timer->id = $current_timer->id;
  $new_timer->student_id = $current_timer->student_id;

  $new_timer->subject_id = intval($_POST['subject_id']) !== 0 ? intval($_POST['subject_id']) : null;
  $new_timer->time_left = intval($_POST['time_left']);
  $new_timer->is_running = $_POST['is_running'] === 'true' || $_POST['is_running'] === '1' ? 1 : 0;
  $new_timer->is_in_working_mode = intval($_POST['is_in_working_mode']);

  $timers_dm->update_for_student($_SESSION['student_id'], $new_timer);
  exit;
?>

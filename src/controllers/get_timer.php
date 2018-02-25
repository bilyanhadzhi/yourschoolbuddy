<?php
  require_once(SRC_DIR . '/data_mappers/timers.dm.php');

  $timers_dm = new TimersDM;
  header('Content-type: text/event-stream; charset=utf-8');

  $data = $timers_dm->get_for_student($_SESSION['student_id']);
  $data_in_json = json_encode($data, JSON_NUMERIC_CHECK);

  print_r($data_in_json);
  exit;
?>

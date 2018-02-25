<?php
  require_once(SRC_DIR . '/data_mappers/stats.dm.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $stats_dm = new StatsDM;
  header('Content-type: application/json; charset=utf-8');

  $data = $stats_dm->get_stats_for_student($_SESSION['student_id'], $_POST['range_start'], $_POST['range_end']);
  $data_in_json = json_encode($data, JSON_NUMERIC_CHECK);

  print_r($data_in_json);
  exit;
?>

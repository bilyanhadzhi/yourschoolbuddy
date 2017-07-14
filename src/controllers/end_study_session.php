<?php
  require_once(SRC_DIR . '/data_mappers/study_sessions.dm.php');
  require_once(SRC_DIR . '/domain_objects/study_session.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    $router->redirect_to('/');
    exit;
  }

  $study_sessions_dm = new StudySessionsDM;

  $student_id = $_SESSION['student_id'];
  $latest_study_session = $study_sessions_dm->get_latest_started_for_student($student_id);

  $study_sessions_dm->end($latest_study_session);
  echo 'OK';
?>

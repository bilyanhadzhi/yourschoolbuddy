<?php
  require_once(SRC_DIR . '/data_mappers/study_sessions.dm.php');
  require_once(SRC_DIR . '/domain_objects/study_session.php');

  $router = new Router;

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $study_sessions_dm = new StudySessionsDM;
  $study_session = new StudySession;

  $subject_id = $_POST['subject_id'] ?? null;

  $study_session->set_subject_id($subject_id);
  $study_session->set_student_id($_SESSION['student_id']);

  $validation_errors = $study_session->validate_begin();

  if ($validation_errors) {
    foreach ($validation_errors as $validation_error) {
      echo $validation_error . "\n";
    }
    exit;
  }

  if ($study_sessions_dm->begin($study_session)) {
    echo 'OK';
  }
?>

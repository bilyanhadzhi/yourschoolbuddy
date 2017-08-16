<?php
  require_once(SRC_DIR . '/data_mappers/students.dm.php');

  $values = ['name' => '', 'password' => ''];
  $title = 'Log in';
  $messages = $_SESSION['messages'] ?? null;

  if ($messages) {
    unset($_SESSION['messages']);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = new Student;
    $student->construct($_POST['name'], $_POST['password']);

    $validation_errors = $student->validate_login();

    if ($validation_errors) {
      $messages = $validation_errors;
    } else {
      $students_dm = new StudentsDM;
      $student = $students_dm->get_by_name($_POST['name'], $_POST['password']);

      if (!$student) {
        $messages[] = 'Username/password do not match any user';
      } else {
        $_SESSION['student_id'] = $student->id;

        $router = new Router;
        $router->redirect_to('/', ['Successfully logged in!'], Router::$FLASH_GREEN);
        exit;
      }
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

<?php
  require_once(SRC_DIR . '/forms/login_form.php');
  require_once(SRC_DIR . '/data_mappers/students.dm.php');

  $values = ['name' => '', 'password' => ''];
  $title = 'Log in';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_form = new LoginForm($_POST['name'], $_POST['password']);
    $values = $login_form->get_values();

    if (!$login_form->is_valid()) {
      $messages = $login_form->get_errors();
    } else {
      $students_dm = new StudentsDM;
      $student = $students_dm->get_by_name($_POST['name'], $_POST['password']);

      if (!$student) {
        $messages[] = 'Username/password do not match any user';
      } else {
        $_SESSION['student_id'] = $student->id;

        $router = new Router;
        $router->redirect_to('/');
      }
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

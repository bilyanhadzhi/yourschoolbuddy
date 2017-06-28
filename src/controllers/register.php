<?php require_once(SRC_DIR . '/routing/router.php') ?>
<?php require_once(SRC_DIR . '/forms/register_form.php') ?>
<?php require_once(SRC_DIR . '/data_mappers/students.dm.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/student.php') ?>

<?php
  $title = 'Register';
  $values = ['name' => '', 'email' => '', 'password' => ''];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register_form = new RegisterForm($_POST['name'], $_POST['email'], $_POST['password']);

    if (!$register_form->is_valid()) {
      $messages = $register_form->get_errors();
    } else {
      $students_dm = new StudentsDM;

      $new_student = new Student;
      $new_student->set_values($_POST['name'], $_POST['email'], $_POST['password']);

      if (!$students_dm->create($new_student)) {
        $values = $register_form->get_values();
        $messages[] = 'A user with the same username and/or email address already exists';
      } else {
        $_SESSION['messages'] = 'You registered successfully!';
        $router = new Router;
        $router->redirect_to('/log_in', $messages);
      }
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

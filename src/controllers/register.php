<?php
  require_once(SRC_DIR . '/routing/router.php');
  require_once(SRC_DIR . '/data_mappers/students.dm.php');
  require_once(SRC_DIR . '/domain_objects/student.php');

  $title = 'Register';
  $values = ['name' => '', 'email' => '', 'password' => ''];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = new Student;
    $student->construct($_POST['name'], $_POST['email'], $_POST['password']);

    $validation_errors = $student->validate_register();

    if ($validation_errors) {
      $messages = $validation_errors;
      $values = [
        'name' => htmlspecialchars($_POST['name']),
        'email' => htmlspecialchars($_POST['email']),
        'password' => htmlspecialchars($_POST['password']),
      ];
    } else {
      $students_dm = new StudentsDM;

      if ($students_dm->exists($student->name, $student->email)) {
        $messages[] = 'A user with the same username and/or email address already exists';
        $values = [
          'name' => htmlspecialchars($_POST['name']),
          'email' => htmlspecialchars($_POST['email']),
          'password' => htmlspecialchars($_POST['password']),
        ];
      } else {
        $students_dm->create($student);
        $messages[] = 'You registered successfully!';

        $router = new Router;
        $router->redirect_to('/log_in', $messages);
        exit;
      }
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

<?php
  require_once(SRC_DIR . '/forms/register_form.php');
  require_once(SRC_DIR . '/data_mappers/students.dm.php');
  require_once(SRC_DIR . '/domain_objects/student.php');

  $title = 'Register';
  $values = ['name' => '', 'email' => '', 'password' => ''];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register_form = new RegisterForm($_POST['name'], $_POST['email'], $_POST['password']);
    $values = $register_form->get_values();

    if (!$register_form->is_valid()) {
      $messages = $register_form->get_errors();
    } else {
      $students_dm = new StudentsDM;

      $new_student = new Student;
      $new_student->set_values($_POST['name'], $_POST['email'], $_POST['password']);

      if (!$students_dm->create($new_student)) {
        $messages[] = 'A user with the same username and/or email address already exists';
      } else {
        $messages[] = 'You registered successfully!';
      }
    }
  }
?>

<?php require_once(SRC_DIR . '/views/' . basename(__FILE__)) ?>

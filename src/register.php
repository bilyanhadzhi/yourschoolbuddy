<?php require_once(SRC_DIR . '/forms/register_form.php') ?>
<?php require_once(SRC_DIR . '/database/database.php') ?>

<?php
  $title = 'Register';
  $values = ['username' => '', 'email' => '', 'password' => ''];

  if (isset($_POST['submit'])) {
    $register_form = new RegisterForm($_POST['username'], $_POST['email'], $_POST['password']);
    $values = $register_form->get_values();

    if (!$register_form->is_valid()) {
      $messages = $register_form->get_errors();
    } else {
      $db = new Database;

      if (!$db->create_user($values['username'], $values['email'], $values['password'])) {
        $messages[] = 'A user with the same username and/or email address already exists';
      } else {
        $messages[] = 'You registered successfully!';
      }
    }
  }
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

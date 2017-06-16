<?php require_once(SRC_DIR . '/forms/login_form.php'); ?>

<?php
  $values = ['username' => '', 'password' => ''];

  if (isset($_POST['submit'])) {
    $login_form = new LoginForm($_POST['username'], $_POST['password']);
    $values = $login_form->get_values();

    if (!$login_form->is_valid()) {
      $flash = $login_form->get_errors();
    } else {
      // TODO: validate login
      echo 'Form was successfully submitted!';
    }
  }
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

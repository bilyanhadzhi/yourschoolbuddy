<?php require_once(SRC_DIR . '/forms/login_form.php'); ?>

<?php
  if (isset($_POST['submit'])) {
    $login_form = new LoginForm($_POST['username'], $_POST['password']);

    if (!$login_form->is_valid()) {
      // TODO: return page w/ errors as flash
      print_r($login_form->get_errors());
      exit;
    } else {
      // TODO: validate login
      echo 'Form was successfully submitted!';
    }
  }
?>

<?php require_once('templates/' . basename(__FILE__, '.php') . '.tpl.php') ?>

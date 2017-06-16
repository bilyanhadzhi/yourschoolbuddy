<?php require_once(SRC_DIR . '/forms/register_form.php') ?>
<?php require_once(SRC_DIR . '/database/database.php') ?>

<?php
  if (isset($_POST['submit'])) {
    $register_form = new RegisterForm($_POST['username'], $_POST['email'], $_POST['password']);

    if (!$register_form->is_valid()) {
      // TODO: render errors in the template
      print_r($register_form->get_errors());
      exit;
    } else {
      $db = new Database;

      if (!$db->create_user($_POST['username'], $_POST['email'], $_POST['password'])) {
        echo 'Username/email already taken';
      } else {
        echo 'User successfully registered!';
      }
    }
  }
?>

<?php require_once('templates/' . basename(__FILE__, '.php') . '.tpl.php') ?>

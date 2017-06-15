<?php require_once(DOCUMENT_ROOT . '/config/db.php') ?>

<?php require_once(SRC_DIR . '/forms/register_form.php') ?>

<?php
  if (isset($_POST['submit'])) {
    $register_form = new RegisterForm($_POST['username'], $_POST['email'], $_POST['password']);

    if (!$register_form->is_valid()) {
      // TODO: render errors in the template
      print_r($register_form->get_errors());
      exit;
    } else {
      // TODO: Check for username/email availability
      $hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);

      $sql = "INSERT INTO users (username, email, password)
              VALUES (:username, :email, :hash)";
      $query = $handler->prepare($sql);
      $query->execute([
        ':username' => $_POST['username'],
        ':email' => $_POST['email'],
        ':hash' => $hash,
      ]);
    }
  }
?>

<?php require_once('templates/' . basename(__FILE__, '.php') . '.tpl.php') ?>

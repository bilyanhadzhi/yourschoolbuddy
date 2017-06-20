<?php require_once(SRC_DIR . '/forms/login_form.php') ?>
<?php require_once(SRC_DIR . '/database/database.php') ?>

<?php
  $values = ['username' => '', 'password' => ''];
  $title = 'Log in';
  $is_post = $_SERVER['REQUEST_METHOD'] === 'POST';

  if ($is_post) {
    $login_form = new LoginForm($_POST['username'], $_POST['password']);
    $values = $login_form->get_values();

    if (!$login_form->is_valid()) {
      $messages = $login_form->get_errors();
    } else {
      $db = new Database;
      $user = $db->get_user_verified($values['username'], $values['password']);

      if (!$user) {
        $messages[] = 'Username/password do not match any user';
      } else {
        $_SESSION['username'] = $user->username;

        $router = new Router;
        $router->redirect_to('/');
      }
    }
  }
?>

<?php require_once('templates/tpl.' . basename(__FILE__)) ?>

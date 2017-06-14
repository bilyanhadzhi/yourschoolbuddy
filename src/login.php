<?php require_once('includes/header.php'); ?>

<?php require_once(DOCUMENT_ROOT . '/config/db.php'); ?>
<?php require_once(SRC_DIR . '/form_validation/login_form.php'); ?>

<?php
  if (isset($_POST['submit'])) {
    $formErrors = formIsInvalid($_POST['username'], $_POST['password']);

    if ($formErrors) {
      // TODO
      echo '<pre>';
      print_r($formErrors);
      echo '</pre>';
      exit;
    } else {
      echo 'Form was successfully submitted!';
    }
  }
?>

<section class="auth-container">
  <h2 class="green">Log in</h2>
  <section class="auth-tab">
    <form action="/login" method="post">
      <input type="text" name="username" placeholder="Username" autofocus>
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="Log In" class="submit-btn">
    </form>
    <span>Don't have an account?</span>
    <a href="/register" class="link">Register</a>
  </section>
</section>

<?php require_once('includes/footer.php'); ?>

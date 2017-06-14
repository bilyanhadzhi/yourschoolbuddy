<?php
  require_once('includes/header.php');
  require_once(DOCUMENT_ROOT . '/config/db.php');
  require_once(SRC_DIR . '/form_validation/register_form.php');
?>
<?php
  if (isset($_POST['submit'])) {
    $formErrors = formIsInvalid($_POST['username'], $_POST['email'], $_POST['password']);

    if ($formErrors) {
      // TODO
      print_r($formErrors);
    } else {
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

<section class="auth-container longer">
  <h2 class="green">Register</h2>
  <section class="auth-tab">
    <form action="/register" method="post">
      <input type="text" name="username" placeholder="Username" required autofocus>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" name="submit" value="Register" class="submit-btn">
    </form>
    <span>Already have an account?</span>
    <a href="/login" class="link">Log in</a>
  </section>
</section>

<?php
  require_once('includes/footer.php');
?>

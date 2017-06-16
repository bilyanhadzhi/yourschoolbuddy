<?php require_once('includes/header.php'); ?>

<section class="auth-container">
  <h2 class="green">Log in</h2>
  <section class="auth-tab">
    <form action="/log_in" method="post">
      <input type="text" name="username" placeholder="Username" autofocus>
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="Log In" class="submit-btn">
    </form>
    <span>Don't have an account?</span>
    <a href="/register" class="link">Register</a>
  </section>
</section>

<?php require_once('includes/footer.php'); ?>

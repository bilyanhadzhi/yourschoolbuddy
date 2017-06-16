<?php require_once('includes/header.php') ?>

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
    <a href="/log_in" class="link">Log in</a>
  </section>
</section>

<?php require_once('includes/footer.php') ?>

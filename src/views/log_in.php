<?php require_once('includes/header.php') ?>

<section class="auth-container">
  <h2 class="green">Log in</h2>
  <section class="auth-tab">
    <?php if (isset($messages)): ?>
      <section class="form-flash">
        <ul>
          <?php foreach ($messages as $message): ?>
            <li><?=$message?></li>
          <?php endforeach ?>
        </ul>
      </section>
    <?php endif ?>
    <form action="/log_in" method="post">
      <input type="text" name="name" placeholder="Username" autofocus required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" name="submit" value="Log In" class="submit-btn">
    </form>
    <span>Don't have an account?</span>
    <a href="/register" class="link">Register</a>
  </section>
</section>

<?php require_once('includes/footer.php') ?>

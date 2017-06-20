<?php require_once('includes/header.php') ?>

<section class="auth-container">
  <h2 class="green">Register</h2>
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
    <form action="/register" method="post">
      <input type="text" name="username" placeholder="Username" required autofocus
             value=<?=$values['username']?>>
      <input type="email" name="email" placeholder="Email" required
             value=<?=$values['email']?>>
      <input type="password" name="password" placeholder="Password" required
             value=<?=$values['password']?>>
      <input type="submit" name="submit" value="Register" class="submit-btn">
    </form>
    <span>Already have an account?</span>
    <a href="/log_in" class="link">Log in</a>
  </section>
</section>

<?php require_once('includes/footer.php') ?>

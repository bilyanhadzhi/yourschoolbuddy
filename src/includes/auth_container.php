<section id="auth-container">
  <h2 class="green" id="tab-status">Log In</h2>
  <section class="auth-tab" id="login-form">
    <form action="<?=$loginURL?>" method="post">
      <input type="text" name="username" placeholder="Username" id="login-username-input" autofocus >
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="Log In" class="submit-btn">
    </form>
    <span>Don't have an account?</span>
    <a href="<?=SRC_DIR . '/register.php'?>" class="link-span">Register</a>
  </section>
  <section class="auth-tab" id="register-form">
    <form action="<?=$registerURL?>" method="post">
      <input type="text" name="username" placeholder="Username" id="register-username-input" autofocus >
      <input type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" name="submit" value="Register" class="submit-btn">
    </form>
    <span>Already have an account?</span>
    <a href="<?=SRC_DIR . '/login.php'?>" class="link-span">Log in</a>
  </section>
</section>

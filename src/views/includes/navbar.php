<nav class="container" id="navbar">
  <ul class="left">
    <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="/">Exams</a></li>
      <li><a href="/">Stats</a></li>
    <?php endif ?>
  </ul>
  <ul class="right">
    <?php if (isset($_SESSION['user_id'])): ?>
      <li><button class="btn" id="study-btn">Study</button></li>
      <li><a href="/log_out">Log Out</a></li>
    <?php else: ?>
      <li><a href="/register">Register</a></li>
      <li><a href="/log_in">Log In</a></li>
    <?php endif ?>
  </ul>
</nav>

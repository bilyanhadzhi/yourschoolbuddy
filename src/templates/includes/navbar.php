<nav class="container" id="navbar">
  <ul>
    <li>
      <a href="/">Tests</a>
    </li>
  </ul>
  <ul>
    <?php if (isset($_SESSION['username'])): ?>
      <li><a href="/log_out">Log Out</a></li>
    <?php else: ?>
      <li><a href="/log_in">Log In</a></li>
    <?php endif ?>
  </ul>
</nav>

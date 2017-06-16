<?php require_once(SRC_DIR . '/models/user.php') ?>

<?php
  class Database {
    public $handler;

    public function __construct() {
      try {
        $this->handler = new PDO(DB_DRIVER, DB_USERNAME, DB_PASSWORD);
        $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo $e;
        exit;
      }
    }

    public function create_user($username, $email, $password) {
      if ($this->user_exists($username, $email)) {
        return false;
      }

      $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

      $sql = "INSERT INTO users (username, email, password)
              VALUES (:username, :email, :hash)";
      $query = $this->handler->prepare($sql);
      $query->execute([
        ':username' => $username,
        ':email' => $email,
        ':hash' => $hash,
      ]);

      return true;
    }

    public function get_user($username) {
      $sql = 'SELECT * FROM users WHERE username=:username LIMIT 1';
      $query = $this->handler->prepare($sql);
      $query->execute([':username' => $username]);
      $query->setFetchMode(PDO::FETCH_CLASS, 'User');

      $user = $query->fetch();
      return $user;
    }

    public function user_exists($username, $email) {
      $sql = 'SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1';
      $query = $this->handler->prepare($sql);

      $query->execute([
        ':username' => $username,
        ':email' => $email,
      ]);

      $user = $query->fetch();

      if ($user) {
        return true;
      } else {
        return false;
      }
    }
  }
?>

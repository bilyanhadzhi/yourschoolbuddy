<?php require_once('form.php') ?>

<?php
  class LoginForm extends Form {
    private $username;
    private $password;

    public function __construct($username, $password) {
      $this->username = $username;
      $this->password = $password;

      $this->validate();
    }

    public function validate() {
      $username_len = strlen($this->username);
      $password_len = strlen($this->password);

      if ($username_len === 0 || $username_len > 50) {
        $this->errors['username'] = ['message' => 'Username is not between 1 and 50 characters long'];
      }
      if ($password_len === 0 || $password_len > 255) {
        $this->errors['password'] = ['message' => 'Password is not between 1 and 255 characters long'];
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

<?php require_once('form.php') ?>

<?php
  class RegisterForm extends Form {
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password) {
      $this->username = $username;
      $this->email = $email;
      $this->password = $password;

      $this->validate();
    }

    public function validate() {
      $username_len = strlen($this->username);
      $email_len = strlen($this->email);
      $password_len = strlen($this->password);

      if ($username_len === 0 || $username_len > 50) {
        $this->errors['username'] = ['message' => 'Username is not between 1 and 50 characters long'];
      }
      if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'][] = ['message' => 'Email is not valid'];
      }
      if ($email_len === 0 || $email_len > 50) {
        $this->errors['email'][] = ['message' => 'Email is not between 1 and 50 characters long'];
      }
      if ($password_len === 0 || $password_len > 255) {
        $this->errors['password'] = ['message' => 'Password is not between 1 and 255 characters long'];
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

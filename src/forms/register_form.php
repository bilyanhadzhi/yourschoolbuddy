<?php require_once('form.php') ?>

<?php
  class RegisterForm extends Form {
    private $name;
    private $email;
    private $password;

    public function __construct($name, $email, $password) {
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;

      $this->sanitize();
      $this->validate();
    }

    public function validate() {
      $name_len = strlen($this->name);
      $email_len = strlen($this->email);
      $password_len = strlen($this->password);

      if ($name_len === 0 || $name_len > 50) {
        $this->errors[] = 'Username is not between 1 and 50 characters long';
      }
      if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $this->errors[] = 'Email is not valid';
      }
      if ($email_len === 0 || $email_len > 50) {
        $this->errors[] = 'Email is not between 1 and 50 characters long';
      }
      if ($password_len === 0 || $password_len > 255) {
        $this->errors[] = 'Password is not between 1 and 255 characters long';
      }

      $this->set_valid_status($this->errors ? false : true);
    }

    public function sanitize() {
      $this->name = preg_replace('/\s+/', '', $this->name);
      $this->email = preg_replace('/\s+/', '', $this->email);
    }

    public function get_values() {
      return [
        'name' => $this->name,
        'email' => $this->email,
        'password' => $this->password,
      ];
    }
  }
?>

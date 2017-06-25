<?php require_once('form.php') ?>

<?php
  class LoginForm extends Form {
    private $name;
    private $password;

    public function __construct($name, $password) {
      $this->name = $name;
      $this->password = $password;

      $this->sanitize();
      $this->validate();
    }

    public function validate() {
      $name_len = strlen($this->name);
      $password_len = strlen($this->password);

      if ($name_len === 0 || $name_len > 50) {
        $this->errors[] = 'Username is not between 1 and 50 characters long';
      }
      if ($password_len === 0 || $password_len > 255) {
        $this->errors[] = 'Password is not between 1 and 255 characters long';
      }

      $this->set_valid_status($this->errors ? false : true);
    }

    public function sanitize() {
      $this->name = preg_replace('/\s+/', '', $this->name);
    }

    public function get_values() {
      return [
        'name' => $this->name,
        'password' => $this->password,
      ];
    }
  }
?>

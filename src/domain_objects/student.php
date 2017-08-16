<?php
  class Student {
    public $name;
    public $password;
    public $registered_on;

    public function construct(string $name, string $password) {
      $this->name = preg_replace('/\s+/', '', $name);
      $this->password = $password;
    }

    public function validate_register() {
      $name_len = strlen($this->name);
      $password_len = strlen($this->password);

      $errors = [];

      if ($name_len === 0 || $name_len > 50) {
        $errors[] = 'Username is not between 1 and 50 characters long';
      }
      if ($password_len < 5 || $password_len > 255) {
        $errors[] = 'Password is not between 6 and 255 characters long';
      }

      return $errors;
    }

    public function validate_login() {
      $name_len = strlen($this->name);
      $password_len = strlen($this->password);

      $errors = [];

      if ($name_len === 0 || $name_len > 50) {
        $errors[] = 'Username is not between 1 and 50 characters long';
      }
      if ($password_len < 5 || $password_len > 255) {
        $errors[] = 'Password is not between 6 and 255 characters long';
      }

      return $errors;
    }
  }
?>

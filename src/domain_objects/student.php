<?php
  class Student {
    public $name;
    public $email;
    public $password;
    public $registered_on;

    public function construct(string $name, $email, string $password) {
      $this->name = preg_replace('/\s+/', '', $name);
      $this->email = preg_replace('/\s+/', '', $email) ?? null;
      $this->password = $password;
    }

    public function validate_register() {
      $name_len = strlen($this->name);
      $email_len = strlen($this->email);
      $password_len = strlen($this->password);

      $errors = [];

      if ($name_len === 0 || $name_len > 50) {
        $errors[] = 'Username is not between 1 and 50 characters long';
      }
      if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is not valid';
      }
      if ($email_len === 0 || $email_len > 50) {
        $errors[] = 'Email is not between 1 and 50 characters long';
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

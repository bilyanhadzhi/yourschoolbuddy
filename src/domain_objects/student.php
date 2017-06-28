<?php
  class Student {
    public $name;
    public $email;
    public $password;
    public $registered_on;

    public function set_values(string $name, string $email, string $password) {
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
    }
  }
?>

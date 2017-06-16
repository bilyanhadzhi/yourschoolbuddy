<?php
  class User {
    private $username;
    private $email;
    private $password;
    private $registered_on;

    public function __construct($username, $email, $password, $registered_on) {
      $this->username = $username;
      $this->email = $email;
      $this->password = $password;
      $this->registered_on = $registered_on;
    }
  }
?>

<?php
  function formIsInvalid($username, $email, $password) {
    $usernameLen = strlen($username);
    $emailLen = strlen($email);
    $passwordLen = strlen($password);

    $errors = [];

    if ($usernameLen === 0 || $usernameLen > 50) {
      $errors['username'] = ['message' => 'Username is not between 1 and 50 characters long'];
    } if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
      $errors['email'][] = ['message' => 'Email is not valid'];
    } if ($emailLen === 0 || $emailLen > 50) {
      $errors['email'][] = ['message' => 'Email is not between 1 and 50 characters long'];
    } if ($passwordLen === 0 || $passwordLen > 255) {
      $errors['password'] = ['message' => 'Password is not between 1 and 255 characters long'];
    }

    if ($errors) {
      return $errors;
    } else {
      return false;
    }
  }
?>

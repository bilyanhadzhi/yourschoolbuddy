<?php
  function formIsInvalid($username, $password) {
    $usernameLen = strlen($username);
    $passwordLen = strlen($password);

    $errors = [];

    if ($usernameLen === 0 || $usernameLen > 50) {
      $errors['username'] = ['message' => 'Username is not between 1 and 50 characters long'];
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

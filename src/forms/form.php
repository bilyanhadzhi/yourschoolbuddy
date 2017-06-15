<?php
  class Form {
    protected $valid_status = false;
    protected $errors = [];

    public function is_valid() {
      return $this->valid_status;
    }

    public function set_valid_status($valid_status) {
      $this->valid_status = $valid_status;
    }

    public function get_errors() {
      return $this->errors;
    }
  }
?>

<?php
  class DataMapper {
    protected $handler;

    public function __construct() {
      $this->connect();
    }

    public function __destruct() {
      $this->disconnect();
    }

    public function connect() {
      try {
        $this->handler = new PDO(DB_DRIVER, DB_USERNAME, DB_PASSWORD);
        $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
      }
    }

    public function disconnect() {
      $this->handler = null;
    }
  }
?>

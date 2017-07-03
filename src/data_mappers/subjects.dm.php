<?php
  require_once('data_mapper.php');
  require_once(SRC_DIR . '/domain_objects/subject.php');

  class SubjectsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function get_all() {
      try {
        $sql = 'SELECT * FROM subjects';

        $query = $this->handler->query($sql);
        $query->setFetchMode(PDO_FETCH_CLASS, 'Subject');

        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

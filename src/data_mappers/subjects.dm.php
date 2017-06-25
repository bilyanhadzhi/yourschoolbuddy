<?php require_once('data_mapper.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/subject.php') ?>

<?php
  class SubjectsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function get_all() {
      try {
        $sql = 'SELECT * FROM subjects';

        return $this->handler
            ->query($sql)
            ->setFetchMode(PDO_FETCH_CLASS, 'Subject')
            ->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

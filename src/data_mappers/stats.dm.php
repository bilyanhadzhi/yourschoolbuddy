<?php
  require_once('data_mapper.php');

  class StatsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function get_daily_time_studied_for_student($student_id) {
      try {
        $sql = 'SELECT * FROM study_sessions
                WHERE student_id = :student_id
                  AND end_date IS NOT NULL';

        $query = $this->handler->prepare($sql);

        $query->execute([':student_id' => $student_id]);

        $query->setFetchMode(PDO::FETCH_CLASS, 'stdClass');

        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }

?>

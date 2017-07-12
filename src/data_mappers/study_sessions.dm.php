<?php
  require_once('data_mapper.php');
  require_once(SRC_DIR . '/domain_objects/study_session.php');

  class StudySessionsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function begin(StudySession $study_session) {
      try {
        $sql = 'INSERT INTO study_sessions ( student_id, subject_id)
                VALUES (:student_id, :subject_id)';

        $query = $this->handler->prepare($sql);

        $query->execute([
          ':student_id' => $study_session->student_id,
          ':subject_id' => $study_session->student_id,
        ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

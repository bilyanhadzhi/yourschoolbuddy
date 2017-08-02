<?php
  require_once('data_mapper.php');
  require_once(SRC_DIR . '/domain_objects/study_session.php');

  class StudySessionsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function begin(StudySession $study_session) {
      try {
        $sql = 'INSERT INTO study_sessions (student_id, subject_id, end_date)
                VALUES (:student_id, :subject_id, NULL)';

        $query = $this->handler->prepare($sql);

        return $query->execute([
          ':student_id' => $study_session->student_id,
          ':subject_id' => $study_session->subject_id,
        ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function end(StudySession $study_session) {
      try {
        $minute_difference = $this->get_minute_difference($study_session->start_date);

        if ($minute_difference === 0) {
          return $this->delete($study_session->id);
        }

        $sql = 'UPDATE study_sessions
                SET end_date = CURRENT_TIMESTAMP
                WHERE id = :id';

        $query = $this->handler->prepare($sql);

        return $query->execute([':id' => $study_session->id]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function delete($id) {
      try {
        $sql = 'DELETE FROM study_sessions WHERE id = :id';

        $query = $this->handler->prepare($sql);

        return $query->execute([':id' => $id]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_forgotten_sessions() {
      try {
        $sql = 'SELECT study_sessions.id
                FROM study_sessions
                JOIN students
                  ON students.id = study_sessions.student_id
                WHERE TIMESTAMPDIFF(MINUTE, students.last_active_on, NOW()) > 30
                  AND study_sessions.end_date IS NULL';

        $query = $this->handler->prepare($sql);

        $query->execute();

        $query->setFetchMode(PDO::FETCH_OBJ);

        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function delete_forgotten_session_by_id($id) {
      if (!$id) {
        return;
      }

      try {
        $sql = 'DELETE FROM study_sessions
                WHERE id = :id';

        $query = $this->handler->prepare($sql);

        return $query->execute([':id' => $id]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function delete_all_forgotten_sessions() {
      try {
        $forgotten_sessions = $this->get_forgotten_sessions();

        foreach ($forgotten_sessions as $forgotten_session) {
          $this->delete_forgotten_session_by_id($forgotten_session->id);
        }
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_latest_started_for_student($student_id) {
      try {
        $sql = 'SELECT * FROM study_sessions
                WHERE student_id = :student_id
                ORDER BY start_date DESC
                LIMIT 1';

        $query = $this->handler->prepare($sql);

        $query->execute([':student_id' => $student_id]);

        $query->setFetchMode(PDO::FETCH_CLASS, 'StudySession');

        return $query->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_minute_difference($start_date) {
      try {
        $sql = 'SELECT TIMESTAMPDIFF(MINUTE, :start_date, CURRENT_TIMESTAMP) AS minute_difference';

        $query = $this->handler->prepare($sql);

        $query->execute([':start_date' => $start_date]);

        $query->setFetchMode(PDO::FETCH_OBJ);

        $result = $query->fetch();

        return (int)$result->minute_difference;
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

<?php
  require_once('data_mapper.php');
  require_once(SRC_DIR . '/domain_objects/student.php');
  require_once(SRC_DIR . '/data_mappers/study_sessions.dm.php');
  require_once(SRC_DIR . '/data_mappers/timers.dm.php');

  class StudentsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function exists(string $name): bool {
      try {
        $sql = 'SELECT * FROM students
                WHERE name = :name
                LIMIT 1';

        $query = $this->handler->prepare($sql);
        $query->execute([':name' => $name]);

        $found = $query->rowCount();
        if ($found) {
          return true;
        }

        return false;

      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function create(Student $student) {
      try {
        $student->password = password_hash($student->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $sql = 'INSERT INTO students (name, password)
                VALUES (:name, :password)';

        $query = $this->handler->prepare($sql);
        $query->execute([
          ':name' => $student->name,
          ':password' => $student->password,
        ]);

        $student_id = $this->handler->lastInsertId();

        $timers_dm = new TimersDM;
        $timers_dm->create_for_student($student_id);

        return true;
      } catch (PDOException $e) {
        echo $e;
        return false;
      }
    }

    public function get_by_id(int $id) {
      try {
        $sql = 'SELECT * FROM students
                WHERE id = :id
                LIMIT 1';

        $query = $this->handler->prepare($sql);

        $query->execute([':id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Student');

        return $query->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_by_name(string $name, string $password = null) {
      try {
        $sql = 'SELECT * FROM students
                WHERE name = :name';

        $query = $this->handler->prepare($sql);

        $query->execute([':name' => $name]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Student');

        $student = $query->fetch();

        if (!$student) {
          return null;
        }

        if (isset($password) && !password_verify($password, $student->password)) {
          return null;
        }

        return $student;
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function update_last_active_on($id) {
      try {
        $sql = 'UPDATE students
                SET last_active_on = CURRENT_TIMESTAMP
                WHERE id = :id';

        $query = $this->handler->prepare($sql);

        $query->execute([':id' => $id]);

        $study_sessions_dm = new StudySessionsDM;

        $study_sessions_dm->delete_all_forgotten_sessions();
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

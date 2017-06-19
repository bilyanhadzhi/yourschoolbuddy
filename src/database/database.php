<?php require_once(SRC_DIR . '/models/user.php') ?>
<?php require_once(SRC_DIR . '/models/subject.php') ?>
<?php require_once(SRC_DIR . '/models/exam.php') ?>
<?php require_once(SRC_DIR . '/models/user_exam.php') ?>
<?php require_once(SRC_DIR . '/models/exam_type.php') ?>

<?php
  class Database {
    public $handler;

    public function __construct() {
      try {
        $this->handler = new PDO(DB_DRIVER, DB_USERNAME, DB_PASSWORD);
        $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo $e;
        exit;
      }
    }

    public function create_user($username, $email, $password) {
      if ($this->user_exists($username, $email)) {
        return false;
      }

      $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

      $sql = 'INSERT INTO users (username, email, password)
              VALUES (:username, :email, :hash)';
      $query = $this->handler->prepare($sql);
      $query->execute([
        ':username' => $username,
        ':email' => $email,
        ':hash' => $hash,
      ]);

      return true;
    }

    public function get_user($username) {
      $sql = 'SELECT * FROM users
              WHERE username=:username LIMIT 1';
      $query = $this->handler->prepare($sql);
      $query->execute([':username' => $username]);
      $query->setFetchMode(PDO::FETCH_CLASS, 'User');

      $user = $query->fetch();
      return $user;
    }

    public function get_user_verified($username, $password) {
      $user = $this->get_user($username);

      if (!$user || !password_verify($password, $user->password)) {
        return false;
      }

      return $user;
    }

    public function user_exists($username, $email) {
      $sql = 'SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1';
      $query = $this->handler->prepare($sql);

      $query->execute([
        ':username' => $username,
        ':email' => $email,
      ]);

      $user = $query->fetch();

      if ($user) {
        return true;
      } else {
        return false;
      }
    }

    public function get_current_user() {
      if (isset($_SESSION['username'])) {
        return $this->get_user($_SESSION['username']);
      } else {
        return null;
      }
    }

    public function get_subjects() {
      $sql = 'SELECT * FROM subjects';
      $query = $this->handler->prepare($sql);
      $query->execute();

      $query->setFetchMode(PDO::FETCH_CLASS, 'Subject');

      $subjects = $query->fetchAll();
      return $subjects;
    }

    public function add_exam($subject_id, $student_id, $type_id, $date, $grade) {
      $sql = 'INSERT INTO exams (subject_id, student_id, type_id, date, grade)
              VALUES (:subject_id, :student_id, :type_id, :date, :grade)';
      $query = $this->handler->prepare($sql);
      $query->execute([
        ':subject_id' => $subject_id,
        ':student_id' => $student_id,
        ':type_id' => $type_id,
        ':date' => $date,
        ':grade' => 'NULL',
      ]);
    }

    public function edit_exam($id, $subject_id, $type_id, $date, $grade) {
      $sql = 'UPDATE exams
              SET subject_id = :subject_id,
                  type_id = :type_id,
                  date = :date,
                  grade = :grade
              WHERE id = :id';

      $query = $this->handler->prepare($sql);
      $query->execute([
        ':id' => $id,
        ':subject_id' => $subject_id,
        ':type_id' => $type_id,
        ':date' => $date,
        ':grade' => $grade,
      ]);
    }

    public function get_exam_types() {
      $sql = 'SELECT * FROM exam_types';
      $query = $this->handler->prepare($sql);
      $query->execute();

      $query->setFetchMode(PDO::FETCH_CLASS, 'ExamType');

      $exam_types = $query->fetchAll();
      return $exam_types;
    }

    public function get_exam_by_id($exam_id) {
      $sql = 'SELECT subjects.name AS subject_name,
                     exams.date AS exam_date,
                     exams.id AS exam_id,
                     exams.student_id AS student_id,
                     exam_types.name AS exam_type
              FROM exams, users, subjects, exam_types
              WHERE users.id = exams.student_id
              AND exams.id = :exam_id
              AND subjects.id = exams.subject_id
              AND exam_types.id = exams.type_id
              LIMIT 1';

      $query = $this->handler->prepare($sql);
      $query->execute([
        ':exam_id' => $exam_id,
      ]);

      $query->setFetchMode(PDO::FETCH_CLASS, 'UserExam');

      $exam = $query->fetch();
      return $exam;
    }

    public function get_exams_by_student_id($student_id) {
      $sql = 'SELECT subjects.name AS subject_name,
                     exams.date AS exam_date,
                     exams.id AS exam_id,
                     exam_types.name AS exam_type,
                     exams.student_id AS student_id
              FROM exams, users, subjects, exam_types
              WHERE users.id = exams.student_id
              AND users.id = :student_id
              AND subjects.id = exams.subject_id
              AND exam_types.id = exams.type_id
              ORDER BY exams.date ASC';

      $query = $this->handler->prepare($sql);
      $query->execute([
        ':student_id' => $student_id,
      ]);

      $query->setFetchMode(PDO::FETCH_CLASS, 'UserExam');

      $exams = $query->fetchAll();
      return $exams;
    }

    public function delete_exam($exam_id) {
      $sql = 'DELETE FROM exams
              WHERE id=:exam_id';

      $query = $this->handler->prepare($sql);
      $query->execute(['exam_id' => $exam_id]);
    }
  }
?>

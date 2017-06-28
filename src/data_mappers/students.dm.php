<?php require_once('data_mapper.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/student.php') ?>

<?php
  class StudentsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function exists(string $name, string $email): bool {
      try {
        $sql = 'SELECT * FROM students
                WHERE name = :name OR email = :email
                LIMIT 1';

        $query = $this->handler->prepare($sql);
        $query->execute([':name' => $name, ':email' => $email]);

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

        $sql = 'INSERT INTO students (name, email, password)
                VALUES (:name, :email, :password)';

        $query = $this->handler->prepare($sql);
        $query->execute([
          ':name' => $student->name,
          ':email' => $student->email,
          ':password' => $student->password,
        ]);

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
  }
?>
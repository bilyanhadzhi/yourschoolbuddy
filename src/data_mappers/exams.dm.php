<?php require_once('data_mapper.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/subject.php') ?>

<?php
  class ExamsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function add(Exam $exam) {
      try {
        $sql = 'INSERT INTO exams (student_id, subject_id, type_id, date, grade)
                VALUES (:student_id, :subject_id, :type_id, :date, :grade)';

        $query = $this->handler->prepare($sql);

        $query->execute([
          ':student_id' => $exam->student_id,
          ':subject_id' => $exam->subject_id,
          ':type_id' => $exam->type_id,
          ':date' => $exam->date,
          ':grade' => $exam->grade,
        ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function edit(Exam $exam) {
      try {
        $sql = 'UPDATE exams
                SET subject_id = :subject_id,
                    type_id = :type_id,
                    date = :date,
                    grade = :grade
                WHERE id = :id';

        $query = $this->handler->prepare($sql);

        $query->execute([
          ':subject_id' => $exam->subject_id,
          ':type_id' => $exam->type_id,
          ':date' => $exam->date,
          ':grade' => $exam->grade,
          ':id' => $exam->id,
        ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_exam_types(): array {
      try {
        $sql = 'SELECT * FROM exam_types';

        $query = $this->handler->prepare($sql);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS, 'ExamType');
        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_grades(): array {
      return ['A', 'B', 'C', 'D', 'E', 'F'];
    }

    public function get_subjects() {
      try {
        $sql = 'SELECT * FROM subjects';

        $query = $this->handler->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'Subject');

        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_by_id(int $id, bool $pretty = true) {
      try {
        $sql = '';

        if (!$pretty) {
          $sql = 'SELECT * FROM exams
                  WHERE id = :exam_id';
        } else {
          $sql = 'SELECT subjects.name AS subject_name,
                        exams.id AS id,
                        exams.student_id AS student_id,
                        exams.date AS date,
                        exams.grade AS grade,
                        exam_types.name AS type_name
                  FROM exams, students, subjects, exam_types
                  WHERE exams.id = :exam_id
                  AND students.id = exams.student_id
                  AND subjects.id = exams.subject_id
                  AND exam_types.id = exams.type_id
                  LIMIT 1';
        }

        $query = $this->handler->prepare($sql);
        $query->execute([':exam_id' => $id]);

        if (!$pretty) {
          $query->setFetchMode(PDO::FETCH_CLASS, 'Exam');
        } else {
          $query->setFetchMode(PDO::FETCH_OBJ);
        }

        return $query->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_for_student(int $student_id) {
      try {
        $sql = 'SELECT subjects.name AS subject_name,
                       exams.date AS date,
                       exams.id AS id,
                       exams.grade AS grade,
                       exam_types.name AS type,
                       exams.student_id AS student_id
                FROM exams, students, subjects, exam_types
                WHERE students.id = :student_id
                AND students.id = exams.student_id
                AND subjects.id = exams.subject_id
                AND exam_types.id = exams.type_id
                ORDER BY exams.date ASC';

        $query = $this->handler->prepare($sql);
        $query->execute([':student_id' => $student_id]);

        $query->setFetchMode(PDO::FETCH_OBJ);
        return $query->fetchAll();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function delete($id) {
      $sql = 'DELETE FROM exams
              WHERE id = :exam_id';

      $query = $this->handler->prepare($sql);
      $query->execute(['exam_id' => $id]);
    }
  }
?>

<?php require_once('data_mapper.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam_type.php') ?>

<?php
  class ExamsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function add(Exam $exam) {
      try {
        $sql = 'INSERT INTO exams (student_id, subject_id,, type_id, date, grade)
                VALUES (:student_id, :subject_id, :type_id, :date, :grade)';

        $this->handler
            ->prepare($sql)
            ->execute([
              ':student_id' => $student_id,
              ':subject_id' => $subject_id,
              ':type_id' => $type_id,
              ':date' => $date,
              ':grade' => $grade,
            ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function edit_by_id(int $id, Exam $new_exam) {
      try {
        $sql = 'UPDATE exams
                SET subject_id = :subject_id,
                    type_id = :type_id,
                    date = :date,
                    grade = :grade
                WHERE id = :id';

        $this->handler
            ->prepare($sql)
            ->execute([
              ':subject_id' => $new_exam->subject_id,
              ':type_id' => $new_exam->type_id,
              ':date' => $new_exam->date,
              ':grade' => $new_exam->grade,
              ':id' => $id,
            ]);
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_exam_types(): array {
      try {
        $sql = 'SELECT * FROM exam_types';

        return $this->handler
            ->query($sql)
            ->setFetchMode(PDO::FETCH_CLASS, 'ExamType')
            ->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_grades(): array {
      return ['A', 'B', 'C', 'D', 'E', 'F'];
    }

    public function get_by_id(int $id): Exam {
      try {
        $sql = 'SELECT subjects.name AS name,
                       exams.id AS id,
                       exams.student_id AS student_id,
                       exams.date AS `date`,
                       exams.grade AS grade,
                       exam_types.name AS type
                FROM exams, students, subjects, exam_types
                WHERE exams.id = :exam_id
                AND students.id = exams.student_id
                AND subjects.id = exams.subject_id
                AND exam_types.id = exams.type_id
                LIMIT 1';

        return $this->handler
            ->prepare($sql)
            ->execute([':exam_id' => $id])
            ->setFetchMode(PDO::FETCH_OBJ)
            ->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function get_for_student(int $student_id): array {
      try {
        $sql = 'SELECT subjects.name AS subject_name,
                       exams.date AS exam_date,
                       exams.id AS exam_id,
                       exams.grade AS exam_grade,
                       exam_types.name AS exam_type,
                       exams.student_id AS student_id
                FROM exams, users, subjects, exam_types
                WHERE users.id = :student_id
                AND users.id = exams.student_id
                AND subjects.id = exams.subject_id
                AND exam_types.id = exams.type_id
                ORDER BY exams.date ASC';

        return $this->handler
            ->prepare($sql)
            ->execute([':student_id' => $student_id])
            ->setFetchMode(PDO::FETCH_OBJ)
            ->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

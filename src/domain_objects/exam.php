<?php
  class Exam {
    public $id;
    public $subject_id;
    public $student_id;
    public $type_id;
    public $date;
    public $grade;


    public function construct($subject_id, $student_id, $type_id, $date, $grade) {
      $this->subject_id = $subject_id;
      $this->student_id = $student_id;
      $this->type_id = $type_id;
      $this->date = $date;
      $this->grade = $grade;
    }

    public function set_subject_id($subject_id) {
      $this->subject_id = $subject_id;
    }

    public function set_type_id($type_id) {
      $this->type_id = $type_id;
    }

    public function set_date($date) {
      $this->date = $date;
    }

    public function set_grade($grade) {
      $this->grade = !empty($grade) ? $grade : null;
    }

    public function validate_create() {
      $errors = [];

      if ($this->subject_id === null) {
        $errors[] = 'You did not select a subject.';
      }
      if ($this->type_id === null) {
        $errors[] = 'You did not select an exam type.';
      }
      if (isset($this->exam_grade)) {
        if (!in_array($this->grade, $grades)) {
          $errors[] = 'You selected an invalid grade.';
        }
      }

      return $errors;
    }

    public function validate_delete() {
      $errors = [];

      if ($this->student_id !== $_SESSION['student_id']) {
        $errors[] = 'The test deleted must be one of your own';
      }

      return $errors;
    }
  }
?>

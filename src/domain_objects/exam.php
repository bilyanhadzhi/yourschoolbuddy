<?php
  class Exam {
    public $id;
    public $subject_id;
    public $student_id;
    public $type_id;
    public $date;
    public $grade;

    public function validate() {
      // TODO
    }

    public function prepare_to_add($subject_id, $student_id, $type_id, $date, $grade) {
      $this->id = null;
      $this->subject_id = $subject_id;
      $this->student_id = $student_id;
      $this->type_id = $type_id;
      $this->date = $date;
      $this->grade = $grade;
    }

    public function set_id($id) {
      $this->id = $id;
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
      $this->grade = $grade;
    }
  }
?>

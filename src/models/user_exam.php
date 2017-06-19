<?php
  class UserExam {
    public $student_id;
    public $subject_name;
    public $exam_date;
    public $exam_id;
    public $exam_type;

    public function get_exam_date() {
      return date('l, jS F', strtotime($this->exam_date));
    }
  }
?>

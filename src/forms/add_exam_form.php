<?php require_once('form.php') ?>

<?php
  class AddExamForm extends Form {
    public $subject_id;
    public $student_id;
    public $exam_type;
    public $exam_date;
    public $exam_grade;

    public function __construct($subject_id, $student_id, $exam_type, $exam_date, $exam_grade) {
      $this->subject_id = $subject_id;
      $this->student_id = $student_id;
      $this->exam_type = $exam_type;
      $this->exam_date = $exam_date;
      $this->exam_grade = $exam_grade;

      $this->validate();
    }

    public function validate() {
      if ($this->subject_id === null) {
        $this->errors[] = 'You did not choose a subject';
      }
      if ($this->exam_type === null) {
        $this->errors[] = 'You did not choose an exam type';
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

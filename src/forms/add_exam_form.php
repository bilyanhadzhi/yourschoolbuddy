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
      $grades = ['NULL', 'A+', 'A', 'B', 'C', 'D', 'F'];

      if ($this->subject_id === null) {
        $this->errors[] = 'You did not select a subject.';
      }
      if ($this->exam_type === null) {
        $this->errors[] = 'You did not select an exam type.';
      }
      if (isset($this->exam_grade)) {
        if (!in_array($this->exam_grade, $grades)) {
          $this->errors[] = 'You selected an invalid grade.';
        }
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

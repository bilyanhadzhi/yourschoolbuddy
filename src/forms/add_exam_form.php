<?php require_once('form.php') ?>

<?php
  class AddExamForm extends Form {
    public $subject_id;
    public $student_id;
    public $type_id;
    public $date;
    public $grade;

    public function __construct($subject_id, $student_id, $type_id, $date, $grade) {
      $this->subject_id = $subject_id;
      $this->student_id = $student_id;
      $this->type_id = $type_id;
      $this->date = $date;
      $this->grade = $grade;

      $this->validate();
    }

    public function validate() {
      $grades = ['NULL', 'A+', 'A', 'B', 'C', 'D', 'F'];

      if ($this->subject_id === null) {
        $this->errors[] = 'You did not select a subject.';
      }
      if ($this->type_id === null) {
        $this->errors[] = 'You did not select an exam type.';
      }
      if (isset($this->exam_grade)) {
        if (!in_array($this->grade, $grades)) {
          $this->errors[] = 'You selected an invalid grade.';
        }
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

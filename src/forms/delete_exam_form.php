<?php require_once('form.php') ?>

<?php
  class DeleteExamForm extends Form {
    private $student_id;
    private $exam;

    public function __construct($student_id, $exam) {
      $this->student_id = $student_id;
      $this->exam = $exam;

      $this->validate();
    }

    public function validate() {
      if ($this->student_id !== $this->exam->student_id) {
        $this->errors[] = 'The test deleted must be one of your own';
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

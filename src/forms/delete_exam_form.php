<?php require_once('form.php') ?>

<?php
  class DeleteExamForm extends Form {
    private $exam_id;
    private $student_id;
    private $current_user_id;

    public function __construct($exam_id, $student_id, $current_user_id) {
      $this->exam_id = $exam_id;
      $this->student_id = $student_id;
      $this->current_user_id = $current_user_id;

      $this->validate();
    }

    public function validate() {
      if ($this->student_id !== $this->current_user_id) {
        $this->errors[] = 'The test deleted must be one of your own';
      }

      $this->set_valid_status($this->errors ? false : true);
    }
  }
?>

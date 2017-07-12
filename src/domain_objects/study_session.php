<?php
  require_once(SRC_DIR . '/data_mappers/subjects.dm.php');

  class StudySession {
    public $id;
    public $start_date;
    public $end_date;
    public $student_id;
    public $subject_id;

    public function set_subject_id($subject_id) {
      $this->subject_id = $subject_id;
    }

    public function validate_begin() {
      $errors = [];

      if ($this->subject_id === null) {
        $errors[] = 'Subject ID does not exist';
      } else {
        $subjects_dm = new SubjectsDM;

        if (!$subjects_dm->get_by_id($this->subject_id)) {
          $errors[] = 'Subject ID is invalid';
        }
      }

      return $errors;
    }

    public function set_student_id($student_id) {
      $this->student_id = $student_id;
    }
  }
?>

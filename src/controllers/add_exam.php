<?php require_once(SRC_DIR . '/data_mappers/exams.dm.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam.php') ?>
<?php require_once(SRC_DIR . '/forms/add_exam_form.php') ?>

<?php
  $router = new Router;

  if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $subject_id = isset($_POST['subject-id']) ? $_POST['subject-id'] : null;
  $type_id = isset($_POST['exam-type-id']) ? $_POST['exam-type-id'] : null;
  $grade = isset($_POST['grade']) ? $_POST['grade'] : null;

  $add_exam_form = new AddExamForm($subject_id, $_POST['student-id'], $type_id, $_POST['exam-date'],
                                   $grade);

  if (!$add_exam_form->is_valid()) {
    $router->redirect_to('/', $add_exam_form->get_errors(), $router->get_flash_class('RED'));
    exit;
  }

  $exams_dm = new ExamsDM;
  $exam = new Exam;

  $exam->set_values($subject_id, $_POST['student-id'], $type_id, $_POST['exam-date'],
                    $grade);

  $exams_dm->add($exam);

  $router->redirect_to('/', ['Exam was added successfully!'], $router->get_flash_class('GREEN'));
?>

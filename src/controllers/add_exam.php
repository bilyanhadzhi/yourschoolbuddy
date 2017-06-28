<?php require_once(SRC_DIR . '/data_mappers/exams.dm.php') ?>
<?php require_once(SRC_DIR . '/domain_objects/exam.php') ?>
<?php require_once(SRC_DIR . '/forms/add_exam_form.php') ?>

<?php
  $router = new Router;

  if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
    $router->redirect_to('/');
    exit;
  }

  $subject_id = $_POST['subject_id'] ?? null;
  $type_id = $_POST['type_id'] ?? null;
  $grade = $_POST['grade'] ?? null;

  $add_exam_form = new AddExamForm($subject_id, $_POST['student_id'],$type_id,
                                   $_POST['exam_date'], $grade);

  if (!$add_exam_form->is_valid()) {
    $router->redirect_to('/', $add_exam_form->get_errors(), $router->get_flash_class('RED'));
    exit;
  }

  $exams_dm = new ExamsDM;
  $exam = new Exam;

  $exam->construct($subject_id, $_POST['student_id'], $type_id, $_POST['exam_date'], $grade);

  $exams_dm->add($exam);

  $router->redirect_to('/', ['Exam was added successfully!'], $router->get_flash_class('GREEN'));
?>

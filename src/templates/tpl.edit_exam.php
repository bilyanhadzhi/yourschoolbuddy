<?php require_once('includes/header.php') ?>

<div class="container">
  <h2 class="green">Edit exam</h2>

  <?php if ($messages): ?>
    <?php foreach ($messages as $message): ?>
      <?=$message?>
    <?php endforeach ?>
  <?php else: ?>
    <form class="add-exam-form" method="post" action="/edit_exam">
      <select name="subject-id" required>
        <option selected disabled>Subject</option>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?=$subject->id?>" <?=$exam->subject_name === $subject->name ? 'selected' : ''?>>
            <?=$subject->name?>
          </option>
        <?php endforeach ?>
      </select>
      <select name="exam-type" required>
        <option selected disabled>Type</option>
        <?php foreach ($exam_types as $exam_type): ?>
          <option value="<?=$exam_type->id?>" <?=$exam->exam_type === $exam_type->name ? 'selected' : ''?>>
          <?=$exam_type->name?>
        </option>
        <?php endforeach ?>
      </select>
      <input type="date" name="exam-date" id="exam-date" required value="<?=$exam->exam_date?>">
      <select name="grade">
        <option disabled selected>Grade</option>
        <option value="NULL" <?=$exam->exam_grade ? '' : 'selected'?>>No grade yet</option>
        <?php foreach($grades as $grade): ?>
          <option value="<?=$grade?>" <?=$exam->exam_grade === $grade ? 'selected' : ''?>>
            <?=$grade?>
          </option>
        <?php endforeach ?>
      </select>
      <input type="hidden" name="student-id" value="<?=$user->id?>" required>
      <input type="hidden" name="exam-id" value="<?=$exam->exam_id?>">
      <input type="submit" class="btn save-btn" value="Save exam">
    </form>
  <?php endif ?>
</div>

<?php require_once('includes/footer.php') ?>

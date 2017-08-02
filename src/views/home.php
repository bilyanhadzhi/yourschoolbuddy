<?php require_once('includes/header.php') ?>

<div class="container">
  <?php require_once('includes/flash_box.php') ?>

  <section class="section-container">
    <h2 class="green">Add an exam</h2>
    <form class="add-exam-form" method="post" action="/add_exam">
      <select name="subject_id">
        <option value="" selected disabled>Subject</option>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?=$subject->id?>"><?=$subject->name?></option>
        <?php endforeach ?>
      </select>
      <select name="type_id">
        <option value="" selected disabled>Type</option>
        <?php foreach ($exam_types as $exam_type): ?>
          <option value="<?=$exam_type->id?>"><?=$exam_type->name?></option>
        <?php endforeach ?>
      </select>
      <input type="date" name="exam_date" id="exam-date" value="<?=$today?>">
      <select name="grade">
        <option value="" selected disabled>Grade</option>
        <option value="">No grade yet</option>
        <?php foreach($grades as $grade): ?>
          <option value="<?=$grade?>"><?=$grade?></option>
        <?php endforeach ?>
      </select>
      <input type="hidden" name="student_id" value="<?=$student->id?>" required>
      <input type="submit" class="btn add-btn" value="Add exam">
    </form>
  </section>

  <section class="section-container">
    <h2 class="green">Upcoming exams</h2>
    <ul class="exams-list">
      <?php if ($exams->upcoming): ?>
        <?php foreach ($exams->upcoming as $upcoming_exam): ?>
          <li>
            <section>
              <span class="subject-name"><?=$upcoming_exam->subject_name?></span>:
              <span><?=date_format(date_create($upcoming_exam->date), 'l, F \t\h\e jS');?></span>,
              <span><?=$upcoming_exam->type?></span>
            </section>
            <section class="exam-management">
              <a class="edit-btn" href="/edit_exam/<?=$upcoming_exam->id?>">Edit</a>
              <form action="/delete_exam" class="inline-form" method="post">
                <input name="exam_id" type="hidden" value="<?=$upcoming_exam->id?>">
                <input name="student_id" type="hidden" value="<?=$student->id?>">
                <input class="inline-form-button delete-btn" type="submit" value="Delete"
                      onclick="return confirm('Are you sure?')">
              </form>
            </section>
          </li>
        <?php endforeach ?>
      <?php else: ?>
        <li>There are no exams here.</li>
      <?php endif ?>
    </ul>
  </section>

  <section class="section-container">
    <h2 class="green">Past exams</h2>
    <ul class="exams-list">
      <?php if ($exams->past): ?>
        <?php foreach ($exams->past as $past_exam): ?>
          <li>
            <section>
              <span class="subject-name"><?=$past_exam->subject_name?></span>:
              <span><?=date_format(date_create($past_exam->date), 'l, F \t\h\e jS');?></span>,
              <span><?=$past_exam->type?></span>
            </section>
            <section class="exam-management">
              <a class="edit-btn" href="/edit_exam/<?=$past_exam->id?>">Edit</a>
              <form action="/delete_exam" class="inline-form" method="post">
                <input name="exam_id" type="hidden" value="<?=$past_exam->id?>">
                <input name="student_id" type="hidden" value="<?=$student->id?>">
                <input class="inline-form-button delete-btn" type="submit" value="Delete"
                      onclick="return confirm('Are you sure?')">
              </form>
            </section>
          </li>
        <?php endforeach ?>
      <?php else: ?>
        <li>There are no exams here.</li>
      <?php endif ?>
    </ul>
  </section>
</div>

<?php require_once('includes/timer.php') ?>

<?php require_once('includes/footer.php') ?>

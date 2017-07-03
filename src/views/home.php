<?php require_once('includes/header.php') ?>

<div class="container">
  <?php if ($messages): ?>
    <section class="flash <?=$messages_class?>">
      <button id="close-flash-btn" class="close-section-btn">&#10005;</button>
      <ul>
        <?php foreach ($messages as $message): ?>
          <li><?=$message?></li>
        <?php endforeach ?>
      </ul>
    </section>
  <?php endif ?>
  <section class="section-container">
    <h2 class="green">Upcoming exams</h2>
    <ul class="exams-list">
      <?php if ($exams): ?>
        <?php foreach ($exams as $exam): ?>
          <li>
            <section>
              <span class="subject-name"><?=$exam->subject_name?></span>:
              <span><?=date_format(date_create($exam->date), 'l, F \t\h\e jS');?></span>,
              <span><?=$exam->type?></span>
            </section>
            <section class="exam-management">
              <a class="edit-btn" href="/edit_exam/<?=$exam->id?>">Edit</a>
              <form action="/delete_exam" class="inline-form" method="post">
                <input name="exam_id" type="hidden" value="<?=$exam->id?>">
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
</div>

<div id="timer" class="hide">
  <header>
    <h4>Timer</h4>
    <button id="close-timer-btn" class="close-section-btn">&#10005;</button>
  </header>
</div>

<?php require_once('includes/footer.php') ?>

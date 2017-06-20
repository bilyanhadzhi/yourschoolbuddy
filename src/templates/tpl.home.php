<?php require_once('includes/header.php') ?>

<div class="container">
  <?php if ($messages): ?>
    <section class="flash <?=$messages_class?>">
      <button id="close-flash-btn">✖</button>
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
              <span><?=$exam->get_exam_date()?></span>,
              <span><?=$exam->exam_type?></span>
            </section>
            <section class="exam-management">
              <a class="edit-btn" href="/edit_exam/<?=$exam->exam_id?>">Edit</a>
              <form action="/delete_exam" class="inline-form" method="post">
                <input name="exam_id" type="hidden" value="<?=$exam->exam_id?>">
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
      <select name="subject-id" required>
        <option selected disabled>Subject</option>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?=$subject->id?>"><?=$subject->name?></option>
        <?php endforeach ?>
      </select>
      <select name="exam-type" required>
        <option selected disabled>Type</option>
        <?php foreach ($exam_types as $exam_type): ?>
          <option value="<?=$exam_type->id?>"><?=$exam_type->name?></option>
        <?php endforeach ?>
      </select>
      <input type="date" name="exam-date" id="exam-date" required value="<?=$today?>">
      <input type="hidden" name="student-id" value="<?=$user->id?>" required>
      <input type="submit" class="btn add-btn" value="Add exam">
    </form>
  </section>
</div>

<?php require_once('includes/footer.php') ?>

<?php require_once('includes/header.php') ?>

<div class="container">
  <section class="section-container">
    <h2 class="green">Upcoming exams</h2>
    <ul class="exams-list">
      <?php foreach ($exams as $exam): ?>
        <li>
          <span><?=$exam['subject_name']?>: <?=date('l, jS F', strtotime($exam['exam_date']))?></span>
          <section class="exam-management">
            <a class="edit-btn">Edit</a>
            <form action="/delete_exam" class="inline-form" method="post">
              <input name="exam_id" type="hidden" value="<?=$exam['exam_id']?>">
              <input class="inline-submit delete-btn" type="submit" value="Delete"
                     onclick="return confirm('Are you sure?')">
            </form>
          </section>
        </li>
      <?php endforeach ?>
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
        <?php foreach ($types as $type): ?>
          <option value="<?=$type['value']?>"><?=$type['name']?></option>
        <?php endforeach ?>
      </select>
      <input type="date" name="exam-date" id="exam-date" required value="<?=$today?>">
      <input type="hidden" name="student-id" value="<?=$user->id?>" required>
      <input type="submit" class="btn add-btn" id="add-exam-btn" value="Add exam">
    </form>
  </section>

  <?php if ($flash): ?>
    <ul>
      <?php foreach ($flash as $message): ?>
        <li><?=$message?></li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</div>

<?php require_once('includes/footer.php') ?>

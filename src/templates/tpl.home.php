<?php require_once('includes/header.php') ?>

<div class="container">
  <h2 class="green">Upcoming exams</h2>
  <ul class="exams-list">
    <?php foreach ($exams as $exam): ?>
      <li>
        <?=$exam->subject_id?>: <?=$exam->date?> |
        <a class="edit-btn hover-underline">Edit</a>
        <a class="delete-btn hover-underline">Delete</a>
      </li>
    <?php endforeach ?>
    <!--<li>
      English: June 16th |
      <a class="edit-btn hover-underline">Edit</a>
      <a class="delete-btn hover-underline">Delete</a>
    </li>
    <li>
      Physics: June 22nd |
      <a class="edit-btn hover-underline">Edit</a>
      <a class="delete-btn hover-underline">Delete</a>
    </li>
    <li>
      Chemistry: June 27th |
      <a class="edit-btn hover-underline">Edit</a>
      <a class="delete-btn hover-underline">Delete</a>
    </li>-->
  </ul>

  <h2 class="green">Add an exam</h2>
  <form class="add-exam-form">
    <select name="subject" id="exam-subject-id">
      <option selected disabled>Subject</option>
      <?php foreach ($subjects as $subject): ?>
        <option value="<?=$subject->id?>"><?=$subject->name?></option>
      <?php endforeach ?>
    </select>
    <select name="type" id="exam-type">
      <option selected disabled>Type</option>
      <?php foreach ($types as $type): ?>
        <option value="<?=$type['value']?>"><?=$type['name']?></option>
      <?php endforeach ?>
    </select>
    <input type="date" id="date">
    <input type="hidden" value="<?=$user->id?>" id="student-id">
    <button type="button" class="btn add-btn" id="add-exam-btn">Add exam</input>
  </form>
</div>

<?php require_once('includes/footer.php') ?>

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

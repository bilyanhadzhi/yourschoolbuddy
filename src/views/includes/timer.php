<div id="timer-container" class="hide">
  <header>
    <h4>Timer</h4>
    <button id="close-timer-btn" class="close-section-btn">&#10005;</button>
  </header>
  <main class="container">
    <section id="timer">00:00</section>
    <section>
      <label for="study-subject">Study for</label>
      <select id="study-subject">
        <option value="" selected disabled>Subject</option>
        <?php foreach ($subjects as $subject): ?>
          <option value="<?=$subject->id?>"><?=$subject->name?></option>
        <?php endforeach ?>
      </select>
    </section>
    <section class="timer-buttons-section">
      <button id="timer-start-pause-btn">Start</button>
      <button id="timer-stop-btn">Stop</button>
    </section>
  </main>
</div>

<div id="timer-bar" class="container">
  <section>
    <span id="timer-bar-time-remaining">00:00</span>
    <span>remaining</span>
  </section>
  <section>
    <span>Status:</span>
    <span id="timer-bar-status">null</span>
  </section>
</div>

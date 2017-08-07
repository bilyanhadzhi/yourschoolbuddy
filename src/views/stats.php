<?php require_once('includes/header.php') ?>

<div class="container">
  <?php require_once('includes/flash_box.php') ?>

  <section class="range-selection-container">
    <select name="range-select" id="range-select">
      <option selected value="range_start=<?=date('Y-m-d', strtotime('monday this week'))?>&range_end=<?=date('Y-m-d', strtotime('sunday this week'))?>">This week</option>
      <option value="range_start=<?=date('Y-m-d', strtotime('first day of this month'))?>&range_end=<?=date('Y-m-d', strtotime('last day of this month'))?>">This month</option>
      <option value="range_start=<?=date('Y-m-d', strtotime('-1 week + 1 day'))?>&range_end=<?=date('Y-m-d')?>">Last 7 days</option>
      <option value="range_start=<?=date('Y-m-d', strtotime('-1 month + 1 day'))?>&range_end=<?=date('Y-m-d')?>">Last 30 days</option>
      <!-- <option value="custom">Custom range</option> -->
    </select>

    <input type="date" value=<?=date('Y-m-d', strtotime('-1 week + 1 day'))?> id="range-start-input" class="destroy">
    <input type="date" value=<?=date('Y-m-d')?> id="range-end-input" class="destroy">

    <button id="reload-stats-btn" class="btn add-btn">Reload</button>
  </section>

  <section class="section-container">
    <section class="chart-container">
      <h2 class="green">Time studied (minutes)</h2>
      <canvas id="time-studied-bar-chart" width="500" height="200"></canvas>
    </section>
    <section class="chart-container">
      <h2 class="green">Time studied per subject (minutes)</h2>
      <canvas id="time-studied-per-subject-bar-chart" width="500" height="200"></canvas>
    </section>
  </section>

</div>

<?php require_once('includes/timer.php') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="/js/stats.js"></script>

<?php require_once('includes/footer.php') ?>

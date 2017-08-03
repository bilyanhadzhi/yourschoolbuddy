<?php require_once('includes/header.php') ?>

<div class="container">
  <?php require_once('includes/flash_box.php') ?>


  <section class="section-container">
    <h2 class="green">Time studied (minutes)</h2>
    <section class="chart-container">
      <canvas id="time-studied-bar-chart" width="500" height="200"></canvas>
    </section>
  </section>

</div>

<?php require_once('includes/timer.php') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="/js/stats.js"></script>

<?php require_once('includes/footer.php') ?>

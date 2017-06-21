document.addEventListener('DOMContentLoaded', function() {
  var flashContainer = document.querySelector('.flash');
  var studyBtn = document.querySelector('#study-btn');

  if (flashContainer) {
    var flashCloseBtn = document.getElementById('close-flash-btn');

    flashCloseBtn.addEventListener('click', function() {
      flashContainer.style.display = 'none';
    });
  }

  if (studyBtn) {
    var timerContainer = document.getElementById('timer');
    var closeTimerBtn = document.getElementById('close-timer-btn');

    studyBtn.addEventListener('click', function() {
      timerContainer.style.display = 'block';
      timerContainer.classList.remove('hide');
    });

    closeTimerBtn.addEventListener('click', function() {
      timerContainer.style.display = 'hidden';
      timerContainer.classList.add('hide');
    });
  }
});

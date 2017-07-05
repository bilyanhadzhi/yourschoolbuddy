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
    var timerContainer = document.getElementById('timer-container');
    var closeTimerBtn = document.getElementById('close-timer-btn');
    var studySubject = document.getElementById('study-subject');
    var timer = document.getElementById('timer');

    var timerBtns = {
      startPauseBtn: document.getElementById('timer-start-pause-btn'),
      stopBtn: document.getElementById('timer-stop-btn'),
    };

    studyBtn.addEventListener('click', function() {
      showTimer();
    });

    closeTimerBtn.addEventListener('click', function() {
      hideTimer();
    });

    timerBtns.startPauseBtn.addEventListener('click', function() {
      if (studySubject.value === "") {
        console.log('No subject selected');
      } else {
        startCountdown(timer);
        triggerStartBtnLabel(timerBtns.startPauseBtn);
      }
    });

    timerBtns.stopBtn.addEventListener('click', function() {
      console.log('Stop!!');
      // TODO
    });
  }

  function showTimer() {
    timerContainer.style.display = 'block';
    timerContainer.classList.remove('hide');
  }

  function hideTimer() {
    timerContainer.style.display = 'hidden';
    timerContainer.classList.add('hide');
  }

  function countdown(timeStr) {
    var timeArr = timeStr.split(':');

    var secondsLeft = parseInt(timeArr[0] * 60 + Number(timeArr[1]));
    secondsLeft--;

    timeArr[0] = parseInt(secondsLeft / 60);
    timeArr[1] = parseInt(secondsLeft % 60);

    timeArr[0] = timeArr[0] < 10 ? '0' + timeArr[0] : timeArr[0];
    timeArr[1] = timeArr[1] < 10 ? '0' + timeArr[1] : timeArr[1];

    return timeArr.join(':');
  }

  function startCountdown(timer) {
    setInterval(function() {
      timer.textContent = countdown(timer.textContent);
    }, 1000)
  }

  function triggerStartBtnLabel(button) {
    if (!button) {
      return false;
    }

    button.textContent = button.textContent === 'Start' ? 'Pause' : 'Start';
  }
});

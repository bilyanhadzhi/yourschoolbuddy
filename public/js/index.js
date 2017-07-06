'use strict';

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
    var closeTimerBtn = document.getElementById('close-timer-btn');
    var studySubject = document.getElementById('study-subject');

    var timer = {
      element: document.getElementById('timer'),
      containerElement: document.getElementById('timer-container'),
      buttons: {
        startPauseBtn: document.getElementById('timer-start-pause-btn'),
        stopBtn: document.getElementById('timer-stop-btn'),
      },
      times: {
        work: '25:00',
        rest: '05:00',
      },
      interval: null,
      isRunning: false,
      isInWorkingMode: true,
      init: function() {
        this.element.textContent = this.times.work;
      },
      show: function() {
        this.containerElement.style.display = 'block';
        this.containerElement.classList.remove('hide');
      },
      hide: function() {
        this.containerElement.style.display = 'hidden';
        this.containerElement.classList.add('hide');
      },
      start: function() {
        this.interval = setInterval(this.countDown.bind(this), 1000);
        this.isRunning = true;
      },
      pause: function() {
        clearInterval(this.interval);
        this.isRunning = false;
      },
      stop: function() {
        this.reset();
        this.isInWorkingMode = true;
      },
      reset: function() {
        this.pause();
        this.init();
      },
      countDown: function() {
        this.element.textContent = countdown(this.element.textContent);
      },
      triggerStartPauseBtnLabel: function() {
        if (this.buttons.startPauseBtn.textContent === 'Start') {
          this.buttons.startPauseBtn.textContent = 'Pause';
        } else {
          this.buttons.startPauseBtn.textContent = 'Start';
        }
      }
    };

    studyBtn.addEventListener('click', function() {
      timer.show();
    });

    closeTimerBtn.addEventListener('click', function() {
      timer.hide();
    });

    timer.buttons.startPauseBtn.addEventListener('click', function() {
      if (studySubject.value === "") {
        alert('No subject selected');
      } else {
        if (timer.isRunning) {
          timer.pause();
        } else {
          timer.start();
        }

        timer.triggerStartPauseBtnLabel();
      }
    });

    timer.buttons.stopBtn.addEventListener('click', function() {
      timer.stop();
    });
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

  function triggerStartBtnLabel(button) {
    if (!button) {
      return false;
    }

    button.textContent = button.textContent === 'Start' ? 'Pause' : 'Start';
  }
});

'use strict';

/* You're about to see some terrible code. :/ Sorry... */

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

    // TODO: refactor this shit
    var timer = {
      element: document.getElementById('timer'),
      containerElement: document.getElementById('timer-container'),
      buttons: {
        startPauseBtn: document.getElementById('timer-start-pause-btn'),
        stopBtn: document.getElementById('timer-stop-btn'),
      },
      bar: {
        element: document.getElementById('timer-bar'),
        timeElement: document.getElementById('timer-bar-time-remaining'),
        statusElement: document.getElementById('timer-bar-status'),
      },
      times: {
        work: '00:10',
        rest: '00:05',
      },
      interval: null,
      isRunning: false,
      isInWorkingMode: true,
      init: function() {
        // TODO: a lot of duplication, terrible code. please fix it :@
        // especially the duplication of the two timers

        if (localStorage.getItem('currentTime') !== this.times.work) {
          this.element.textContent = localStorage.getItem('currentTime');
          this.bar.timeElement.textContent = this.element.textContent;

          this.isInWorkingMode = localStorage.getItem('isInWorkingMode');
          studySubject.value = localStorage.getItem('subjectID');

          // TODO: refactor all of this shit
          this.bar.element.className = 'container';
          this.bar.element.className += this.isInWorkingMode ? ' timer-work' : ' timer-rest';
          this.bar.statusElement.textContent = this.isInWorkingMode ? 'working' : 'resting';

          if (localStorage.getItem('isRunning')) {
            this.start();
            this.buttons.startPauseBtn.textContent = 'Pause ';
          }
        } else {
          this.element.textContent = this.times.work;
          this.bar.timeElement.textContent = this.element.textContent;

          this.bar.element.className = 'container timer-not-running';
          this.bar.statusElement.textContent = 'not running';
        }
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
        localStorage.setItem('isRunning', 'true');

        this.bar.element.className = 'container';
        this.bar.element.className += this.isInWorkingMode ? ' timer-work' : ' timer-rest';
        this.bar.statusElement.textContent = this.isInWorkingMode ? 'working' : 'resting';
      },
      pause: function() {
        clearInterval(this.interval);
        this.isRunning = false;
        localStorage.setItem('isRunning', '');
      },
      reset: function() {
        this.pause();

        this.element.textContent = this.times.work;

        this.bar.timeElement.textContent = this.element.textContent;
        this.bar.element.className = 'container timer-not-running';
        this.bar.statusElement.textContent = 'not running';

        this.isInWorkingMode = true;
        studySubject.value = "";

        localStorage.setItem('currentTime', this.times.work);
        localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
        localStorage.setItem('subjectID', studySubject.value);
      },
      countDown: function() {
        if (this.element.textContent === '00:00') {
          this.changeStatus();
        } else {
          this.element.textContent = countdown(this.element.textContent);
        }

        this.bar.timeElement.textContent = this.element.textContent;

        localStorage.setItem('currentTime', this.element.textContent);
        localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
        localStorage.setItem('subjectID', studySubject.value);
      },
      changeStatus: function() {
        this.isInWorkingMode = !this.isInWorkingMode;

        localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
        this.element.textContent = this.isInWorkingMode ? this.times.work : this.times.rest;

        if (this.isInWorkingMode) {
          this.bar.element.classList.remove('timer-rest');
          this.bar.element.classList.add('timer-work');
          this.bar.statusElement.textContent = 'working';
        } else {
          this.bar.element.classList.remove('timer-work');
          this.bar.element.classList.add('timer-rest');
          this.bar.statusElement.textContent = 'resting';
        }
      },
      triggerStartPauseBtnLabel: function() {
        if (this.buttons.startPauseBtn.textContent === 'Start') {
          this.buttons.startPauseBtn.textContent = 'Pause';
        } else {
          this.buttons.startPauseBtn.textContent = 'Start';
        }
      }
    };

    timer.init();

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
      timer.reset();
      timer.buttons.startPauseBtn.textContent = 'Start';
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

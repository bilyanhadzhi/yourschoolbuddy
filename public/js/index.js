'use strict';

document.addEventListener('DOMContentLoaded', function() {
  var user = {
    init: function() {
      this.setUpStatusUpdates();
    },
    setUpStatusUpdates: function() {
      this.updateLastActiveOn();
      setInterval(this.updateLastActiveOn.bind(this), 60000);
    },
    updateLastActiveOn: function() {
      var url = '/update_last_active_on';

      var request = new XMLHttpRequest();

      request.open('POST', url, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      request.onreadystatechange = function() {
        if(request.readyState === 4 && request.status === 200) {
          console.log(request.responseText);
        }
      };

      request.send();
    }
  };

  var flash = {
    init: function() {
      if (!this.checkIfExists()) {
        return null;
      }

      this.cacheDom();
      this.bindEvents();
    },
    checkIfExists: function() {
      var flashElement = document.querySelector('.flash');

      return flashElement ? true : false;
    },
    cacheDom: function() {
      this.element = document.querySelector('.flash');
      this.closeButton = document.getElementById('close-flash-btn');
    },
    bindEvents: function() {
      this.closeButton.addEventListener('click', this.close.bind(this));
    },
    close: function() {
      this.element.style.display = 'none';
    },
  };

  var timer = {
    times: {
      work: 25 * 60,
      rest: 5 * 60,
    },
    state: {
      currentTime: null,
      currentSubject: null,
      isInWorkingMode: null,
      isRunning: null,
    },
    init: function() {
      if (!this.checkIfExists()) {
        return null;
      }

      this.cacheDom();
      this.bindEvents();

      this.setInitialState();
      this.render();
    },
    checkIfExists: function() {
      var studyButtonEl = document.querySelector('#study-btn');

      return studyButtonEl ? true : false;
    },
    cacheDom: function() {
      this.el = document.getElementById('timer');
      this.containerEl = document.getElementById('timer-container');
      this.subjectEl = document.getElementById('study-subject');
      this.buttons = {
        studyButtonEl: document.getElementById('study-btn'),
        closeContainerButtonEl: document.getElementById('close-timer-btn'),
        startPauseButtonEl: document.getElementById('timer-start-pause-btn'),
        resetButtonEl: document.getElementById('timer-reset-btn'),
      };
      this.bottomBar = {
        el: document.getElementById('timer-bar'),
        timeEl: document.getElementById('timer-bar-time-remaining'),
        statusEl: document.getElementById('timer-bar-status'),
      };
    },
    bindEvents: function() {
      this.buttons.studyButtonEl.addEventListener('click', this.openContainer.bind(this));
      this.buttons.closeContainerButtonEl.addEventListener('click', this.closeContainer.bind(this));
      this.buttons.startPauseButtonEl.addEventListener('click', this.handleStartOrPause.bind(this));
      this.buttons.resetButtonEl.addEventListener('click', this.handleReset.bind(this));
      this.subjectEl.addEventListener('change', this.updateCurrentSubject.bind(this));
      window.addEventListener('keydown', this.handleKeyPress.bind(this));
    },
    render: function() {
      this.updateTime();
      this.updateCurrentSubject();

      this.updateBarStatus();
      this.updateBarColor();

      this.updateStartPauseButtonLabel();
    },
    setInitialState: function() {
      if (!this.checkIfTimeInLocalStorage()) {
        this.state.isRunning = false;
        this.state.isInWorkingMode = true;
        this.state.currentTime = this.times.work;
        this.state.currentSubject = null;
      } else {
        this.state.isRunning = JSON.parse(localStorage.getItem('isRunning'));
        this.state.isInWorkingMode = JSON.parse(localStorage.getItem('isInWorkingMode'));
        this.state.currentTime = JSON.parse(localStorage.getItem('currentTime'));
        this.state.currentSubject = JSON.parse(localStorage.getItem('currentSubject'));

        if (this.state.currentSubject) {
          this.subjectEl.value = this.state.currentSubject;
        }

        if (this.state.isRunning) {
          this.start();
        }
      }
    },
    checkIfTimeInLocalStorage: function() {
      if (!localStorage.getItem('currentTime')) {
        return false;
      } else if (!localStorage.getItem('isRunning')) {
        return false;
      } else if (!localStorage.getItem('isInWorkingMode')) {
        return false;
      }
      return true;
    },
    start: function() {
      this.countDown();
      this.interval = setInterval(this.countDown.bind(this), 1000);
      this.state.isRunning = true;
    },
    countDown: function() {
      if (this.state.currentTime <= 0) {
        this.changeStatus();
        this.pause();
      } else {
        this.state.currentTime--;
      }

      this.updateLocalStorage();
      this.render();
    },
    pause: function() {
      clearInterval(this.interval);
      this.state.isRunning = false;

      this.endStudySession();
      this.updateLocalStorage();
    },
    reset: function() {
      this.pause();

      this.state.currentTime = this.times.work;
      this.state.isInWorkingMode = true;
      this.state.currentSubject = null;

      this.subjectEl.children[0].selected = true;

      this.updateLocalStorage();
      this.endStudySession();
    },
    handleStartOrPause: function() {
      if (this.subjectEl.value === '') {
        alert('No subject selected');
        return;
      } else if (this.state.isRunning) {
        this.pause();
        this.endStudySession();
      } else {
        this.start();
        this.beginStudySession();
      }

      this.render();
    },
    handleReset: function() {
      this.reset();
      this.render();
    },
    handleKeyPress: function(e) {
      var keysLookup = [27, 83, 84];

      if (!keysLookup.includes(e.keyCode)) {
        return;
      } else {
        switch (e.keyCode) {
          case 83:
            this.handleStartOrPause();
            break;
          case 84:
            this.triggerContainer();
            break;
          case 27:
            if (!this.containerEl.classList.contains('hide')) {
              this.closeContainer();
            }
            break;
        }
      }
    },
    updateTime: function() {
      this.el.textContent = this.secondsToTimeStr(this.state.currentTime);
      this.bottomBar.timeEl.textContent = this.secondsToTimeStr(this.state.currentTime);
    },
    updateCurrentSubject: function() {
      if (this.subjectEl.value === '') {
        return;
      } else if (this.state.currentSubject !== this.subjectEl.value) {
        this.state.currentSubject = this.subjectEl.value;

        if (this.state.isRunning) {
          this.resetStudySession();
        }
      }
    },
    updateLocalStorage: function() {
      localStorage.setItem('currentTime', this.state.currentTime);
      localStorage.setItem('currentSubject', this.state.currentSubject);
      localStorage.setItem('isRunning', this.state.isRunning);
      localStorage.setItem('isInWorkingMode', this.state.isInWorkingMode);
    },
    updateStartPauseButtonLabel: function() {
      this.buttons.startPauseButtonEl.textContent = this.state.isRunning ? 'Pause' : 'Start';
    },
    updateBarStatus: function() {
      if (!this.state.isRunning && this.state.currentTime === this.times.work) {
        this.bottomBar.statusEl.textContent = 'not running';
      } else {
        this.bottomBar.statusEl.textContent = this.state.isInWorkingMode ? 'working' : 'resting';
      }
    },
    updateBarColor: function() {
      if (!this.state.isRunning) {
        if (!this.bottomBar.el.classList.contains('timer-not-running')) {
          this.bottomBar.el.classList.remove('timer-rest', 'timer-work');
          this.bottomBar.el.classList.add('timer-not-running');
        }
      } else if (!this.state.isInWorkingMode) {
        if (!this.bottomBar.el.classList.contains('timer-rest')) {
          this.bottomBar.el.classList.remove('timer-not-running', 'timer-work');
          this.bottomBar.el.classList.add('timer-rest');
        }
      } else {
        if (!this.bottomBar.el.classList.contains('timer-work')) {
          this.bottomBar.el.classList.remove('timer-not-running', 'timer-rest');
          this.bottomBar.el.classList.add('timer-work');
        }
      }
    },
    changeStatus: function() {
      this.state.isInWorkingMode = !this.state.isInWorkingMode;

      this.state.currentTime = this.state.isInWorkingMode ? this.times.work : this.times.rest;

      if (!this.state.isInWorkingMode) {
        this.endStudySession();
      } else {
        this.beginStudySession();
      }
    },
    secondsToTimeStr: function(seconds) {
      var timeArr = [parseInt(seconds / 60, 10), parseInt(seconds % 60, 10)];

      timeArr = timeArr.map(function(secondsSegment) {
        return secondsSegment < 10 ? '0' + secondsSegment : secondsSegment;
      });

      return timeArr.join(':');
    },
    openContainer: function() {
      this.containerEl.style.display = 'block';
      this.containerEl.classList.remove('hide');

      this.subjectEl.focus();
    },
    closeContainer: function() {
      this.containerEl.style.display = 'hidden';
      this.containerEl.classList.add('hide');
    },
    triggerContainer: function() {
      if (this.containerEl.classList.contains('hide')) {
        this.openContainer();
      } else {
        this.closeContainer();
      }
    },
    beginStudySession: function() {
      if (!this.state.isInWorkingMode) {
        return;
      }

      var url = '/begin_study_session';
      var params = 'subject_id=' + this.subjectEl.value;

      var request = new XMLHttpRequest();

      request.open('POST', url, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      request.onreadystatechange = function() {
        if(request.readyState === 4 && request.status === 200) {
          console.log(request.responseText);
        }
      };

      request.send(params);
    },
    endStudySession: function() {
      var url = '/end_study_session';

      var request = new XMLHttpRequest();

      request.open('PUT', url, true);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      request.onreadystatechange = function() {
        if(request.readyState === 4 && request.status === 200) {
          console.log(request.responseText);
        }
      };

      request.send();
    },
    resetStudySession: function() {
      this.endStudySession();
      this.beginStudySession();
    },
  };

  user.init();
  flash.init();
  timer.init();
});

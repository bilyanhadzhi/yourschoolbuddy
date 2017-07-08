'use strict';

document.addEventListener('DOMContentLoaded', function() {
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
      work: 10,
      rest: 5,
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
    },
    render: function() {
      this.updateTime();

      this.updateBarStatus();
      this.updateBarColor();

      this.updateStartPauseButtonLabel();

      console.log(this.state);
    },
    setInitialState: function() {
      if (!this.checkIfTimeInLocalStorage()) {
        this.state.isRunning = false;
        this.state.isInWorkingMode = true;
        this.state.currentTime = this.times.work;
        this.state.currentSubject = null;
      } else {
        this.state.isRunning = localStorage.getItem('isRunning');
        this.state.isInWorkingMode = localStorage.getItem('isInWorkingMode');
        this.state.currentTime = localStorage.getItem('currentTime');
        this.state.currentSubject = localStorage.getItem('currentSubject');
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
      this.interval = setInterval(this.countDown.bind(this), 1000);
      this.state.isRunning = true;
    },
    countDown: function() {
      if (this.state.currentTime <= 0) {
        this.changeStatus();
      } else {
        this.state.currentTime--;
      }

      this.render();
    },
    pause: function() {
      clearInterval(this.interval);
      this.state.isRunning = false;
    },
    reset: function() {
      this.pause();

      this.state.currentTime = this.times.work;
      this.isInWorkingMode = true;
    },
    handleStartOrPause: function() {
      if (this.state.isRunning) {
        this.pause();
      } else {
        this.start();
      }

      this.render();
    },
    handleReset: function() {
      this.reset();
      this.render();
    },
    updateTime: function() {
      this.el.textContent = this.secondsToTimeStr(this.state.currentTime);
      this.bottomBar.timeEl.textContent = this.secondsToTimeStr(this.state.currentTime);
    },
    updateStartPauseButtonLabel: function() {
      this.buttons.startPauseButtonEl.textContent = this.state.isRunning ? 'Pause' : 'Start';
    },
    updateBarStatus: function() {
      if (!this.state.isRunning) {
        if (this.state.currentTime === this.times.work) {
          this.bottomBar.statusEl.textContent = 'not running';
        }
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
    },
    secondsToTimeStr: function(seconds) {
      var timeArr = [parseInt(seconds / 60), parseInt(seconds % 60)];

      timeArr = timeArr.map(function(secondsSegment) {
        return secondsSegment < 10 ? '0' + secondsSegment : secondsSegment;
      });

      return timeArr.join(':');
    },
    openContainer: function() {
      this.containerEl.style.display = 'block';
      this.containerEl.classList.remove('hide');
    },
    closeContainer: function() {
      this.containerEl.style.display = 'hidden';
      this.containerEl.classList.add('hide');
    },
  };

  flash.init();
  timer.init();


  // var studyBtn = document.querySelector('#study-btn');
  // if (studyBtn) {
  //   var closeTimerBtn = document.getElementById('close-timer-btn');
  //   var studySubject = document.getElementById('study-subject');

  //   // TODO: refactor this shit
  //   var timer = {
  //     element: document.getElementById('timer'),
  //     containerElement: document.getElementById('timer-container'),
  //     buttons: {
  //       startPauseBtn: document.getElementById('timer-start-pause-btn'),
  //       stopBtn: document.getElementById('timer-stop-btn'),
  //     },
  //     bar: {
  //       element: document.getElementById('timer-bar'),
  //       timeElement: document.getElementById('timer-bar-time-remaining'),
  //       statusElement: document.getElementById('timer-bar-status'),
  //     },
  //     times: {
  //       work: '00:10',
  //       rest: '00:05',
  //     },
  //     interval: null,
  //     isRunning: false,
  //     isInWorkingMode: true,
  //     init: function() {
  //       // TODO: a lot of duplication, terrible code. please fix it :@
  //       // especially the duplication of the two timers

  //       if (localStorage.getItem('currentTime') !== this.times.work) {
  //         this.element.textContent = localStorage.getItem('currentTime');
  //         this.bar.timeElement.textContent = this.element.textContent;

  //         this.isInWorkingMode = localStorage.getItem('isInWorkingMode');
  //         studySubject.value = localStorage.getItem('subjectID');

  //         // TODO: refactor all of this shit
  //         this.bar.element.className = 'container';
  //         this.bar.element.className += this.isInWorkingMode ? ' timer-work' : ' timer-rest';
  //         this.bar.statusElement.textContent = this.isInWorkingMode ? 'working' : 'resting';

  //         if (localStorage.getItem('isRunning')) {
  //           this.start();
  //           this.buttons.startPauseBtn.textContent = 'Pause ';
  //         }
  //       } else {
  //         this.element.textContent = this.times.work;
  //         this.bar.timeElement.textContent = this.element.textContent;

  //         this.bar.element.className = 'container timer-not-running';
  //         this.bar.statusElement.textContent = 'not running';
  //       }
  //     },
  //     show: function() {
  //       this.containerElement.style.display = 'block';
  //       this.containerElement.classList.remove('hide');
  //     },
  //     hide: function() {
  //       this.containerElement.style.display = 'hidden';
  //       this.containerElement.classList.add('hide');
  //     },
  //     start: function() {
  //       this.interval = setInterval(this.countDown.bind(this), 1000);
  //       this.isRunning = true;
  //       localStorage.setItem('isRunning', 'true');

  //       this.bar.element.className = 'container';
  //       this.bar.element.className += this.isInWorkingMode ? ' timer-work' : ' timer-rest';
  //       this.bar.statusElement.textContent = this.isInWorkingMode ? 'working' : 'resting';
  //     },
  //     pause: function() {
  //       clearInterval(this.interval);
  //       this.isRunning = false;
  //       localStorage.setItem('isRunning', '');
  //     },
  //     reset: function() {
  //       this.pause();

  //       this.element.textContent = this.times.work;

  //       this.bar.timeElement.textContent = this.element.textContent;
  //       this.bar.element.className = 'container timer-not-running';
  //       this.bar.statusElement.textContent = 'not running';

  //       this.isInWorkingMode = true;
  //       studySubject.value = "";

  //       localStorage.setItem('currentTime', this.times.work);
  //       localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
  //       localStorage.setItem('subjectID', studySubject.value);
  //     },
  //     countDown: function() {
  //       if (this.element.textContent === '00:00') {
  //         this.changeStatus();
  //       } else {
  //         this.element.textContent = countdown(this.element.textContent);
  //       }

  //       this.bar.timeElement.textContent = this.element.textContent;

  //       localStorage.setItem('currentTime', this.element.textContent);
  //       localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
  //       localStorage.setItem('subjectID', studySubject.value);
  //     },
  //     changeStatus: function() {
  //       this.isInWorkingMode = !this.isInWorkingMode;

  //       localStorage.setItem('isInWorkingMode', this.isInWorkingMode ? 'true' : '');
  //       this.element.textContent = this.isInWorkingMode ? this.times.work : this.times.rest;

  //       if (this.isInWorkingMode) {
  //         this.bar.element.classList.remove('timer-rest');
  //         this.bar.element.classList.add('timer-work');
  //         this.bar.statusElement.textContent = 'working';
  //       } else {
  //         this.bar.element.classList.remove('timer-work');
  //         this.bar.element.classList.add('timer-rest');
  //         this.bar.statusElement.textContent = 'resting';
  //       }
  //     },
  //     triggerStartPauseBtnLabel: function() {
  //       if (this.buttons.startPauseBtn.textContent === 'Start') {
  //         this.buttons.startPauseBtn.textContent = 'Pause';
  //       } else {
  //         this.buttons.startPauseBtn.textContent = 'Start';
  //       }
  //     }
  //   };

    // timer.init();

    // studyBtn.addEventListener('click', function() {
    //   timer.show();
    // });

    // closeTimerBtn.addEventListener('click', function() {
    //   timer.hide();
    // });

    // timer.buttons.startPauseBtn.addEventListener('click', function() {
    //   if (studySubject.value === "") {
    //     alert('No subject selected');
    //   } else {
    //     if (timer.isRunning) {
    //       timer.pause();
    //     } else {
    //       timer.start();
    //     }

    //     timer.triggerStartPauseBtnLabel();
    //   }
    // });

  //   timer.buttons.stopBtn.addEventListener('click', function() {
  //     timer.reset();
  //     timer.buttons.startPauseBtn.textContent = 'Start';
  //   });
  // }

  // function countdown(timeStr) {
  //   var timeArr = timeStr.split(':');

  //   var secondsLeft = parseInt(timeArr[0] * 60 + Number(timeArr[1]));
  //   secondsLeft--;

  //   timeArr[0] = parseInt(secondsLeft / 60);
  //   timeArr[1] = parseInt(secondsLeft % 60);

  //   timeArr[0] = timeArr[0] < 10 ? '0' + timeArr[0] : timeArr[0];
  //   timeArr[1] = timeArr[1] < 10 ? '0' + timeArr[1] : timeArr[1];

  //   return timeArr.join(':');
  // }

  // function triggerStartBtnLabel(button) {
  //   if (!button) {
  //     return false;
  //   }

  //   button.textContent = button.textContent === 'Start' ? 'Pause' : 'Start';
  // }
});

'use strict';

document.addEventListener('DOMContentLoaded', function() {
  var statsAPI = {
    url: '/api/stats',
    request: new XMLHttpRequest(),
    chartInfo: {
      labels: [],
      data: [],
    },
    getForPeriod: function(params) {
      this.request.open('POST', this.url, true);
      this.request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      this.request.onreadystatechange = this.handleResponse.bind(this);
      this.request.send(params);
    },
    handleResponse: function() {
      var response = null;

      if(this.request.readyState === 4 && this.request.status === 200) {
        response = JSON.parse(this.request.responseText);

        Object.keys(charts).forEach(function(chartName) {
          charts[chartName].data.labels = [];
          charts[chartName].data.datasets[0].data = [];
        });

        Object.keys(response.timeStudiedDaily).forEach(function(date) {
          charts.timeStudiedDaily.data.labels.push(date);
          charts.timeStudiedDaily.data.datasets[0].data.push(response.timeStudiedDaily[date]);
        }.bind(this));

        Object.keys(response.timeStudiedPerSubject)
          .sort(function(a, b) {
            return response.timeStudiedPerSubject[b] - response.timeStudiedPerSubject[a];
          })
          .forEach(function(subjectName) {
            charts.timeStudiedPerSubject.data.labels.push(subjectName);
            charts.timeStudiedPerSubject.data.datasets[0].data.push(response.timeStudiedPerSubject[subjectName]);
          }.bind(this));

        charts.timeStudiedDaily.update();
        charts.timeStudiedPerSubject.update();
      }
    },
  };

  var chart = {
    create: function(selector, options) {
      var context = document.getElementById(selector).getContext('2d');

      return new Chart(context, options);
    },
  };

  var timeStudiedDailyChartOptions = {
    type: 'bar',
    data: {
      labels: null,
      datasets: [{
        data: null,
        label: 'Time studied',
        backgroundColor: 'rgba(56,142,60, 0.7)',
        borderColor: 'rgba(56,142,60, 0.9)',
        borderWidth: 1,
      }],
    },
    options: {
      tooltips: {
        callbacks: {
          label: function(tooltipItem) {
            if (tooltipItem.yLabel < 0) {
              return null;
            }

            var minutes = Math.floor(Math.abs(tooltipItem.yLabel));
            var seconds = Math.floor((Math.abs(tooltipItem.yLabel) * 60) % 60);

            var formatted = minutes + (minutes === 1 ? ' minute' : ' minutes');

            if (seconds !== 0) {
              formatted += ' and ' + seconds;
              formatted += seconds === 1 ? ' second' : ' seconds';
            }

            return formatted;
          },
          title: function(tooltipItem, chartData) {
            return moment(chartData.labels[tooltipItem[0].index]).format("ddd, MMM Do");
          },
        },
      },
      legend: {
        display: false,
      },
      responsive: true,
      scales: {
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
            fontFamily: '"Nunito", sans-serif',
            fontSize: 13,
            stepSize: 30,
          },
        }],
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false,
          },
          ticks: {
            callback: function(label, index, labels) {
              return moment(label).format("MMM Do");
            },
            fontFamily: '"Nunito", sans-serif',
            fontSize: 13,
            fontStyle: 'bold',
          },
        }],
      },
    },
  };

  var timeStudiedPerSubjectChartOptions = {
    type: 'bar',
    data: {
      labels: null,
      datasets: [{
        data: null,
        label: 'Time studied',
        backgroundColor: 'rgba(56,142,60, 0.7)',
        borderColor: 'rgba(56,142,60, 0.9)',
        borderWidth: 1,
      }],
    },
    options: {
      tooltips: {
        callbacks: {
          label: function(tooltipItem) {
            if (tooltipItem.yLabel < 0) {
              return null;
            }

            var minutes = Math.floor(Math.abs(tooltipItem.yLabel));
            var seconds = Math.floor((Math.abs(tooltipItem.yLabel) * 60) % 60);

            var formatted = minutes + (minutes === 1 ? ' minute' : ' minutes');

            if (seconds !== 0) {
              formatted += ' and ' + seconds;
              formatted += seconds === 1 ? ' second' : ' seconds';
            }

            return formatted;
          },
        },
      },
      legend: {
        display: false,
      },
      responsive: true,
      scales: {
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
            fontFamily: '"Nunito", sans-serif',
            fontSize: 13,
            stepSize: 30,
          },
        }],
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false,
          },
          ticks: {

          },
        }],
      },
    },
  };

  var rangeSelection = {
    init: function() {
      this.cacheDom();
      this.bindEvents();
    },
    cacheDom: function() {
      this.rangeSelectorEl = document.getElementById('range-select');
      this.rangeInputs = {
        start: document.getElementById('range-start-input'),
        end: document.getElementById('range-end-input'),
      };
      this.reloadButton = document.getElementById('reload-stats-btn');
    },
    bindEvents: function() {
      this.rangeSelectorEl.addEventListener('change', this.handleChange.bind(this));
      this.reloadButton.addEventListener('click', this.handleReload.bind(this));
    },
    handleChange: function() {
    },
    handleReload: function() {
      statsAPI.getForPeriod(this.rangeSelectorEl.value);
    },
    setRangeInputStatus: function(status) {
      if (status === true) {
        this.rangeInputs.forEach(function(rangeInput) {
          if (rangeInput.classList.contains('destroy')) {
            rangeInput.classList.remove('destroy');
          }
        });
      } else {
        this.rangeInputs.forEach(function(rangeInput) {
          if (!rangeInput.classList.contains('destroy')) {
            rangeInput.classList.add('destroy');
          }
        });
      }
    },
  };

  rangeSelection.init();
  statsAPI.getForPeriod(rangeSelection.rangeSelectorEl.value);

  var charts = {
    timeStudiedDaily: chart.create('time-studied-bar-chart', timeStudiedDailyChartOptions),
    timeStudiedPerSubject: chart.create('time-studied-per-subject-bar-chart', timeStudiedPerSubjectChartOptions),
  };
});

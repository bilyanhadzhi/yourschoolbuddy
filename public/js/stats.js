'use strict';

document.addEventListener('DOMContentLoaded', function() {
  var statsAPI = {
    url: '/api/stats',
    request: new XMLHttpRequest(),
    chartInfo: {
      labels: [],
      data: [],
    },
    getForPeriod: function(range_start, range_end) {
      var params = 'range_start=' + range_start + '&range_end=' + range_end;

      this.request.open('POST', this.url, true);
      this.request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

      this.request.onreadystatechange = this.handleResponse.bind(this);
      this.request.send(params);
    },
    handleResponse: function() {
      var response = null;

      if(this.request.readyState === 4 && this.request.status === 200) {
        response = JSON.parse(this.request.responseText);

        Object.keys(response).forEach(function(date) {
          this.chartInfo.labels.push(date);
          this.chartInfo.data.push(response[date]);
        }.bind(this));

        chart.create('time-studied-bar-chart', barChartOptions);
      }
    },
  };

  var chart = {
    create: function(selector, options) {
      var context = document.getElementById(selector).getContext('2d');

      new Chart(context, options);
    },
  };

  statsAPI.getForPeriod('2017-07-26', '2017-08-04');

  var barChartOptions = {
    type: 'bar',
    data: {
      labels: statsAPI.chartInfo.labels,
      datasets: [{
        data: statsAPI.chartInfo.data,
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
          ticks: {
            beginAtZero: true,
            callback: function(label, index, labels) {
              if (Math.floor(label) === label) {
                return label;
              } else {
                return '';
              }
            },
            fontFamily: '"Nunito", sans-serif',
            fontSize: 13,
          }
        }],
        xAxes: [{
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
          }
        }],
      },
    },
  };
});

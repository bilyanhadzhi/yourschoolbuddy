'use strict';

document.addEventListener('DOMContentLoaded', function() {
  var url = '/api/stats';
  var params = 'range_start=' + '2017-07-26' + '&range_end=' + '2017-08-04';

  var request = new XMLHttpRequest();

  request.open('POST', url, true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

  var response = null;
  var labels = [];
  var data = [];

  request.onreadystatechange = function() {
    if(request.readyState === 4 && request.status === 200) {
      response = JSON.parse(request.responseText);

      Object.keys(response).forEach(function(date) {
        labels.push(date);
        data.push(response[date]);
      });

      createChart(labels, data, barChartOptions);
    }
  };

  request.send(params);

  function decimalToMinutesAndSeconds(minutes) {
    if (minutes < 0) {
      return null;
    }

    var min = Math.floor(Math.abs(minutes));
    var sec = Math.floor((Math.abs(minutes) * 60) % 60);

    var formatted = min + (min === 1 ? ' minute' : ' minutes');

    if (sec !== 0) {
      formatted += ' and ' + sec;
      formatted += sec === 1 ? ' second' : ' seconds';
    }

    return formatted;
  }

  var barChartOptions = {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        label: 'Time studied',
        backgroundColor: 'rgba(56,142,60, 0.7)',
        borderColor: 'rgba(56,142,60, 0.9)',
        borderWidth: 1,
      }],
    },
    options: {
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return decimalToMinutesAndSeconds(tooltipItem.yLabel);
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

  function createChart(labels, data, options) {
    var context = document.getElementById('time-studied-bar-chart').getContext('2d');

    var barChart = new Chart(context, options);
  }
});

'use strict';

(function() {
  var url = '/api/stats';
  var params = 'range_start=' + '2017-07-01' + '&range_end=' + '2017-08-01';

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

      console.log(labels, data);
    }
  };

  request.send(params);
})();

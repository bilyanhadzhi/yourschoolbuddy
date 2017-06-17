document.addEventListener('DOMContentLoaded', function() {
  var date = document.getElementById('date') || null;

  if (date) {
    date.value = new Date().toISOString().slice(0, 10);

    var addExamButton = document.getElementById('add-exam-btn');

    var exam = {
      subjectID: document.getElementById('exam-subject-id'),
      studentID: document.getElementById('student-id'),
      type: document.getElementById('exam-type'),
      date: date,
    };

    addExamButton.addEventListener('click', function() {
      makeAddExamRequest(exam);
    });
  }


  function makeAddExamRequest(exam) {
    if (exam.subjectID.value === 'Subject' || exam.type.value === 'Type') {
      return false;
    }

    var request = new XMLHttpRequest();
    request.open('POST', '/add_exam', true);

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    var params = 'subject_id=' + exam.subjectID.value;
    params += '&type=' + exam.type.value;
    params += '&date=' + exam.date.value;
    params += '&student_id=' + exam.studentID.value;

    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        console.log(request.responseText);
      }
    }

    console.log(params);
    request.send(params);
  }
});

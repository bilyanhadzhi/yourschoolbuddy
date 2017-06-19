document.addEventListener('DOMContentLoaded', function() {
  console.log('Hey');
  document.querySelectorAll('.subject-name').forEach(function(subjectName) {
    subjectName.addEventListener('click', function() {
      console.log(this.textContent);
    });
  });
});

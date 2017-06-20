document.addEventListener('DOMContentLoaded', function() {
  var flashContainer = document.querySelector('.flash');

  if (flashContainer) {
    var flashCloseBtn = document.getElementById('close-flash-btn');

    flashCloseBtn.addEventListener('click', function() {
      flashContainer.style.display = 'none';
    });
  }
});

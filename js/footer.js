let box = document.getElementById('footer'),
    btn = document.querySelector('footer-btn');

function showhide() {
  
  if (box.classList.contains('hidden')) {
    box.classList.remove('hidden');
    setTimeout(function () {
      box.classList.remove('visuallyhidden');
    }, 20);
  } else {
    box.classList.add('visuallyhidden');    
    box.addEventListener('transitionend', function(e) {
      box.classList.add('hidden');
    }, {
      capture: false,
      once: true,
      passive: false
    });
  }
  
};
//employee-user login
const btns = document.querySelectorAll('.pagebtn');
const frames = document.querySelectorAll('.frames');

var frameActive = function (manual) {
  btns.forEach((btn) => {
    btn.classList.remove('active');
  });
  frames.forEach((slide) => {
    slide.classList.remove('active');
  });

  btns[manual].classList.add('active');
  frames[manual].classList.add('active');
};

btns.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    frameActive(i);
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const pageButtons = document.querySelectorAll('.pagebtn');
  const frames = document.querySelectorAll('.frames');

  pageButtons.forEach((button, index) => {
      button.addEventListener('click', () => {
          // Remove active class from all buttons and frames
          pageButtons.forEach(btn => btn.classList.remove('active'));
          frames.forEach(frame => frame.classList.remove('active'));

          // Add active class to clicked button and corresponding frame
          button.classList.add('active');
          frames[index].classList.add('active');
      });
  });
});


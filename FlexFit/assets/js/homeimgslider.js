let slideIndexBnr = 0;
let sliderTimer;

showSlides();

function showSlides() {
  let slides = document.getElementsByClassName("slide");
  let labels = document.getElementsByClassName("label");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.opacity = "0";
  }
  slideIndexBnr++;
  if (slideIndexBnr > slides.length) {
    slideIndexBnr = 1;
  }
  for (let i = 0; i < labels.length; i++) {
    labels[i].classList.remove("active");
  }
  slides[slideIndexBnr - 1].style.opacity = "1";
  labels[slideIndexBnr - 1].classList.add("active");
  sliderTimer = setTimeout(showSlides, 5000); // Changes image every 5 seconds
}
// for when user clicks on image tab manually 
let radios = document.querySelectorAll('.radio');
radios.forEach((radio, index) => {
  radio.addEventListener('click', function() {
    clearTimeout(sliderTimer);
    slideIndexBnr = index;
    showSlides();
  });
});

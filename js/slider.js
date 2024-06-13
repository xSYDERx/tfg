const slides = document.querySelector('.slides');
const images = document.querySelectorAll('.slides img');
const totalImages = images.length;

let index = 0;

function nextSlide() {
    index++;
    if (index >= totalImages) {
        index = 0;
    }
    slides.style.transform = `translateX(${-index * 100}%)`;
}

setInterval(nextSlide, 3000);

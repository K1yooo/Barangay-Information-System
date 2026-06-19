let currentIndex = 0;
const slides = document.querySelectorAll('.slider img');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = (i === index) ? 'block' : 'none';
    });
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}
showSlide(currentIndex);
setInterval(nextSlide, 3000);

document.getElementById('scroll-to-mission-vision').addEventListener('click', function() {
    document.getElementById('mission').scrollIntoView({ behavior: 'smooth' });
    setTimeout(function() {
        document.getElementById('vision').scrollIntoView({ behavior: 'smooth' });
    }, 1000); 
});

document.getElementById('scroll-to-vision-mission').addEventListener('click', function() {
    document.getElementById('mission').scrollIntoView({ behavior: 'smooth' });
    setTimeout(function() {
        document.getElementById('vision').scrollIntoView({ behavior: 'smooth' });
    }, 1000); 
});
document.getElementById("theme_btn").addEventListener("click", function(event) {
    window.location.href = this.href;
});

document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('nav ul');

    menuToggle.addEventListener('click', function () {
        navMenu.classList.toggle('active');
    });
});




/**
 * Fix for the Trading Market Image Slider
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing image slider fix');
    
    function fixCarousel() {
        const carousel = document.getElementById('carousel-slides');
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');
        
        console.log('Carousel elements:', {
            carousel: !!carousel,
            slides: slides.length,
            dots: dots.length,
            prevBtn: !!prevBtn,
            nextBtn: !!nextBtn
        });
        
        if (!carousel || slides.length === 0) return;
        
        let currentIndex = 0;
        let interval;
        
        function goToSlide(index) {
            currentIndex = index;
            if (currentIndex < 0) currentIndex = slides.length - 1;
            if (currentIndex >= slides.length) currentIndex = 0;
            
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
            
            dots.forEach((dot, i) => {
                if (i === currentIndex) {
                    dot.classList.add('carousel-dot-active');
                } else {
                    dot.classList.remove('carousel-dot-active');
                }
            });
        }
        
        function startAutoSlide() {
            clearInterval(interval);
            interval = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 5000);
        }
        
        function stopAutoSlide() {
            clearInterval(interval);
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', e => {
                e.preventDefault();
                goToSlide(currentIndex - 1);
                stopAutoSlide();
                startAutoSlide();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', e => {
                e.preventDefault();
                goToSlide(currentIndex + 1);
                stopAutoSlide();
                startAutoSlide();
            });
        }
        
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                goToSlide(i);
                stopAutoSlide();
                startAutoSlide();
            });
        });
        
        startAutoSlide();
    }
    
    setTimeout(fixCarousel, 500);
});

/**
 * Additional fixes for Stallion Signal Pro
 * This file contains fixes for the Trading Market Image Slider and FAQ section
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Loading fixes.js - additional fixes for Stallion Signal Pro');
    
    // ============================
    // Fix Trading Market Image Slider
    // ============================
    function fixImageCarousel() {
        console.log('Initializing fixed image carousel...');
        const carousel = document.getElementById('carousel-slides');
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');
        
        if (!carousel || slides.length === 0) {
            console.log('Carousel elements missing, cannot initialize');
            return;
        }
        
        console.log('Found carousel with', slides.length, 'slides and', dots.length, 'dots');
        
        let currentIndex = 0;
        let interval;
        
        // Update active dot
        function updateDots() {
            if (!dots || dots.length === 0) {
                console.log('No carousel dots found');
                return;
            }
            
            dots.forEach((dot, i) => {
                if (i === currentIndex) {
                    dot.classList.add('carousel-dot-active');
                    dot.classList.add('bg-white');
                    dot.classList.remove('bg-opacity-50');
                } else {
                    dot.classList.remove('carousel-dot-active');
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-opacity-50');
                }
            });
        }
        
        // Move to specific slide
        function goToSlide(index) {
            currentIndex = index;
            if (currentIndex < 0) currentIndex = slides.length - 1;
            if (currentIndex >= slides.length) currentIndex = 0;
            
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateDots();
            console.log('Moved to slide', currentIndex);
        }
          
        // Setup automatic rotation
        function startAutoSlide() {
            clearInterval(interval);
            interval = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 5000); // Change slide every 5 seconds
        }
        
        function stopAutoSlide() {
            clearInterval(interval);
        }
        
        // Event listeners for navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                console.log('Previous button clicked');
                goToSlide(currentIndex - 1);
                stopAutoSlide();
                startAutoSlide();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                console.log('Next button clicked');
                goToSlide(currentIndex + 1);
                stopAutoSlide();
                startAutoSlide();
            });
        }
        
        // Dots navigation
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                console.log('Dot clicked:', i);
                goToSlide(i);
                stopAutoSlide();
                startAutoSlide();
            });
        });
          
        // Pause on hover
        if (carousel.parentElement) {
            carousel.parentElement.addEventListener('mouseenter', stopAutoSlide);
            carousel.parentElement.addEventListener('mouseleave', startAutoSlide);
        }
        
        // Initialize slider
        updateDots();
        startAutoSlide();
        console.log('Image carousel fixed and initialized with', slides.length, 'slides');
    }

    // ============================
    // Fix FAQ Section
    // ============================
    function fixFaqAccordion() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        console.log('Found', faqQuestions.length, 'FAQ questions');
        
        if (faqQuestions.length === 0) {
            console.log('No FAQ questions found');
            // Try to add event listeners again after a delay
            setTimeout(fixFaqAccordion, 1000);
            return;
        }
        
        // Helper function to toggle answer visibility
        function toggleAnswer(answerElement, iconElement) {
            if (!answerElement) return;
            
            // Toggle visibility
            answerElement.classList.toggle('hidden');
            
            // Update icon rotation if icon exists
            if (iconElement) {
                if (answerElement.classList.contains('hidden')) {
                    iconElement.style.transform = 'rotate(0deg)';
                } else {
                    iconElement.style.transform = 'rotate(180deg)';
                }
            }
            
            console.log('Answer toggled:', answerElement.classList.contains('hidden') ? 'hidden' : 'visible');
        }
        
        // Remove any existing click listeners first (to avoid duplicates)
        faqQuestions.forEach((question) => {
            const newQuestion = question.cloneNode(true);
            question.parentNode.replaceChild(newQuestion, question);
        });
        
        // Add new click listeners
        document.querySelectorAll('.faq-question').forEach((question) => {
            question.addEventListener('click', function(e) {
                console.log('FAQ question clicked:', this.innerText.substring(0, 30) + '...');
                e.preventDefault();
                e.stopPropagation(); // Prevent event bubbling
                
                // Find the parent container
                const parent = this.closest('.border-b');
                if (!parent) {
                    console.log('FAQ parent container not found, trying alternative parent selector');
                    const altParent = this.closest('div');
                    if (!altParent) {
                        console.log('No parent container found at all');
                        return;
                    }
                }
                
                // Find the answer element (next sibling after the button)
                const answer = parent ? parent.querySelector('.faq-answer') : this.parentNode.querySelector('.faq-answer');
                if (!answer) {
                    console.log('FAQ answer not found, trying alternative selector');
                    // Try to find the answer element in the DOM
                    const siblingElements = Array.from(this.parentNode.children);
                    const answerIndex = siblingElements.indexOf(this) + 1;
                    if (answerIndex < siblingElements.length) {
                        const possibleAnswer = siblingElements[answerIndex];
                        if (possibleAnswer.classList.contains('faq-answer')) {
                            console.log('Found answer using sibling index');
                            toggleAnswer(possibleAnswer, this.querySelector('i'));
                            return;
                        }
                    }
                    console.log('No answer element found using any method');
                    return;
                }
                
                // Find the icon
                const icon = this.querySelector('i');
                
                // Toggle the answer
                toggleAnswer(answer, icon);
                
                // Close other FAQs
                document.querySelectorAll('.faq-question').forEach(q => {
                    if (q !== this) {
                        const otherParent = q.closest('.border-b') || q.parentNode;
                        if (!otherParent) return;
                        
                        const otherAnswer = otherParent.querySelector('.faq-answer');
                        const otherIcon = q.querySelector('i');
                        
                        if (otherAnswer && !otherAnswer.classList.contains('hidden')) {
                            otherAnswer.classList.add('hidden');
                            
                            if (otherIcon) {
                                otherIcon.style.transform = 'rotate(0deg)';
                            }
                        }
                    }
                });
            });
        });
        
        console.log('FAQ accordion fixed');
    }
    
    // Initialize fixes with a delay to ensure DOM is fully loaded
    setTimeout(() => {
        // Debug the DOM elements we need
        console.log('Checking for carousel elements:');
        console.log('- carousel-slides:', document.getElementById('carousel-slides') ? 'Found' : 'Not found');
        console.log('- carousel-slide elements:', document.querySelectorAll('.carousel-slide').length);
        console.log('- carousel-dot elements:', document.querySelectorAll('.carousel-dot').length);
        
        console.log('Checking for FAQ elements:');
        console.log('- faq-question elements:', document.querySelectorAll('.faq-question').length);
        console.log('- faq-answer elements:', document.querySelectorAll('.faq-answer').length);
        
        // Initialize fixes
        fixImageCarousel();
        fixFaqAccordion();
    }, 1000); // Increased delay for better reliability
});

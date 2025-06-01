/**
 * Fix for the FAQ accordion
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing FAQ fix');
    
    function fixFAQ() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        console.log('Found FAQ questions:', faqQuestions.length);
        
        if (faqQuestions.length === 0) return;
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', function(e) {
                e.preventDefault();
                
                const answer = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                if (!answer || !answer.classList.contains('faq-answer')) {
                    console.log('Could not find answer element directly');
                    // Try alternative methods
                    const parent = this.closest('div');
                    if (parent) {
                        const altAnswer = parent.querySelector('.faq-answer');
                        if (altAnswer) {
                            toggleFAQ(this, altAnswer, icon);
                            return;
                        }
                    }
                    return;
                }
                
                toggleFAQ(this, answer, icon);
            });
        });
        
        function toggleFAQ(question, answer, icon) {
            answer.classList.toggle('hidden');
            
            if (icon) {
                icon.style.transform = answer.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
            
            // Close other FAQs
            faqQuestions.forEach(q => {
                if (q !== question) {
                    const otherAnswer = q.nextElementSibling;
                    const otherIcon = q.querySelector('i');
                    
                    if (otherAnswer && otherAnswer.classList.contains('faq-answer')) {
                        otherAnswer.classList.add('hidden');
                        if (otherIcon) {
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    } else {
                        const otherParent = q.closest('div');
                        if (otherParent) {
                            const altAnswer = otherParent.querySelector('.faq-answer');
                            if (altAnswer && !altAnswer.classList.contains('hidden')) {
                                altAnswer.classList.add('hidden');
                                if (otherIcon) {
                                    otherIcon.style.transform = 'rotate(0deg)';
                                }
                            }
                        }
                    }
                }
            });
        }
    }
    
    setTimeout(fixFAQ, 500);
});

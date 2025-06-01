// Mobile guides dropdown functionality with enhanced animations
document.addEventListener('DOMContentLoaded', function() {
    const mobileGuidesButton = document.getElementById('mobile-guides-button');
    const mobileGuidesDropdown = document.getElementById('mobile-guides-dropdown');
    
    if (mobileGuidesButton && mobileGuidesDropdown) {
        mobileGuidesButton.addEventListener('click', function() {
            // Get the chevron icon
            const icon = this.querySelector('i');
            
            if (mobileGuidesDropdown.classList.contains('hidden')) {
                // Show dropdown with animation
                mobileGuidesDropdown.classList.remove('hidden');
                
                // Use setTimeout to ensure the transition works
                setTimeout(() => {
                    mobileGuidesDropdown.classList.remove('opacity-0', 'transform', '-translate-y-2');
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                }, 10);
            } else {
                // Hide dropdown with animation
                mobileGuidesDropdown.classList.add('opacity-0', 'transform', '-translate-y-2');
                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
                
                // After animation completes, hide the element completely
                setTimeout(() => {
                    mobileGuidesDropdown.classList.add('hidden');
                }, 300);
            }
        });
        
        // Close mobile dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileGuidesButton && 
                mobileGuidesDropdown && 
                !mobileGuidesButton.contains(e.target) && 
                !mobileGuidesDropdown.contains(e.target) && 
                !mobileGuidesDropdown.classList.contains('hidden')) {
                
                // Hide dropdown with animation
                mobileGuidesDropdown.classList.add('opacity-0', 'transform', '-translate-y-2');
                const icon = mobileGuidesButton.querySelector('i');
                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
                
                // After animation completes, hide the element completely
                setTimeout(() => {
                    mobileGuidesDropdown.classList.add('hidden');
                }, 300);
            }
        });
    }
});

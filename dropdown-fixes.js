/**
 * Navigation functionality for Stallion Signal Pro
 * This script handles all dropdown menus and mobile navigation
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dropdown fixes loading...');
    
    // Detect if we're on mobile or desktop
    const isMobile = window.innerWidth < 768;
    console.log('Device type:', isMobile ? 'Mobile' : 'Desktop');    // ============================
    // Desktop Guides Dropdown
    // ============================
    const guidesNavItem = document.getElementById('guides-nav-item');
    const guidesDropdown = document.getElementById('guides-dropdown');
    const guidesNavBtn = document.getElementById('guides-nav-btn');
    
    if (guidesNavItem && guidesDropdown && guidesNavBtn) {
        console.log('Desktop guides dropdown elements found');
        
        // Track dropdown timeout
        let dropdownTimeout = null;
        
        // Toggle dropdown on click
        guidesNavBtn.addEventListener('click', function(e) {
            console.log('Guides nav button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const isActive = guidesDropdown.classList.contains('active');
            
            if (isActive) {
                hideDesktopGuidesDropdown(false); // No delay on click
            } else {
                showDesktopGuidesDropdown();
            }
        });
        
        // Helper functions for showing/hiding dropdown
        function showDesktopGuidesDropdown() {
            console.log('Showing desktop guides dropdown');
            // Clear any pending hide timeouts
            if (dropdownTimeout) {
                clearTimeout(dropdownTimeout);
                dropdownTimeout = null;
            }
            guidesDropdown.classList.add('active');
            if (guidesNavBtn.querySelector('i')) {
                guidesNavBtn.querySelector('i').style.transform = 'rotate(180deg)';
            }
        }
        
        function hideDesktopGuidesDropdown(withDelay = true) {
            if (withDelay) {
                // Add 200ms delay before hiding dropdown
                console.log('Scheduling dropdown hide with 200ms delay');
                if (dropdownTimeout) {
                    clearTimeout(dropdownTimeout); // Clear any existing timeout
                }
                
                dropdownTimeout = setTimeout(function() {
                    console.log('Hiding desktop guides dropdown after delay');
                    guidesDropdown.classList.remove('active');
                    if (guidesNavBtn.querySelector('i')) {
                        guidesNavBtn.querySelector('i').style.transform = 'rotate(0deg)';
                    }
                    dropdownTimeout = null;
                }, 200);
            } else {
                // Hide immediately
                console.log('Hiding desktop guides dropdown immediately');
                if (dropdownTimeout) {
                    clearTimeout(dropdownTimeout); // Clear any existing timeout
                    dropdownTimeout = null;
                }
                guidesDropdown.classList.remove('active');
                if (guidesNavBtn.querySelector('i')) {
                    guidesNavBtn.querySelector('i').style.transform = 'rotate(0deg)';
                }
            }
        }
        
        // Show dropdown on hover for desktop (wider screens)
        if (window.innerWidth >= 768) { // 768px is Tailwind's md breakpoint
            guidesNavItem.addEventListener('mouseenter', function() {
                console.log('Mouse entered guides nav item');
                showDesktopGuidesDropdown();
            });
            
            guidesNavItem.addEventListener('mouseleave', function() {
                console.log('Mouse left guides nav item');
                hideDesktopGuidesDropdown(true); // With 200ms delay
            });
        }
          // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (guidesDropdown.classList.contains('active') && !guidesNavItem.contains(e.target)) {
                console.log('Clicked outside guides dropdown');
                hideDesktopGuidesDropdown(false); // No delay when clicking outside
            }
        });
    } else {
        console.log('Some desktop guides dropdown elements not found');
    }
    
    // ============================
    // Mobile Menu Toggle
    // ============================
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        console.log('Mobile menu elements found');
        
        // Create overlay for mobile menu if it doesn't exist
        let menuOverlay = document.getElementById('mobile-menu-overlay');
        if (!menuOverlay) {
            menuOverlay = document.createElement('div');
            menuOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 hidden';
            menuOverlay.id = 'mobile-menu-overlay';
            document.body.appendChild(menuOverlay);
            console.log('Created mobile menu overlay');
        }
          // Toggle mobile menu
        mobileMenuButton.addEventListener('click', function() {
            console.log('Mobile menu button clicked');
            
            // Toggle menu visibility
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('visible');
            menuOverlay.classList.toggle('hidden');
            
            // Prevent body scrolling when menu is open
            if (!mobileMenu.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
          // Close menu when clicking overlay
        menuOverlay.addEventListener('click', function() {
            console.log('Mobile menu overlay clicked');
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('visible');
            menuOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        });
    } else {
        console.log('Some mobile menu elements not found');
    }
    
    // ============================
    // Mobile Guides Dropdown
    // ============================
    const mobileGuidesButton = document.getElementById('mobile-guides-button');
    const mobileGuidesDropdown = document.getElementById('mobile-guides-dropdown');
    
    if (mobileGuidesButton && mobileGuidesDropdown) {
        console.log('Mobile guides dropdown elements found');
        
        // Initialize dropdown state
        mobileGuidesDropdown.style.maxHeight = '0px';
        
        mobileGuidesButton.addEventListener('click', function(e) {
            console.log('Mobile guides button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle the dropdown
            const isActive = mobileGuidesDropdown.classList.contains('active');
            const chevron = this.querySelector('i');
            
            if (isActive) {
                console.log('Hiding mobile guides dropdown');
                mobileGuidesDropdown.classList.remove('active');
                mobileGuidesDropdown.style.maxHeight = '0px';
                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
            } else {
                console.log('Showing mobile guides dropdown');
                mobileGuidesDropdown.classList.add('active');
                mobileGuidesDropdown.style.maxHeight = mobileGuidesDropdown.scrollHeight + 'px';
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        });
    } else {
        console.log('Some mobile guides dropdown elements not found');
    }    // Handle window resize events for responsive behavior
    let lastWidth = window.innerWidth;
    window.addEventListener('resize', function() {
        const wasDesktop = lastWidth >= 768;
        const isNowDesktop = window.innerWidth >= 768;
        lastWidth = window.innerWidth;
        
        // If we've changed between mobile and desktop modes
        if (wasDesktop !== isNowDesktop) {
            console.log('View mode changed to:', isNowDesktop ? 'Desktop' : 'Mobile');
            
            // Reset any states that need to be reset
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('mobile-menu-overlay');
            const guidesDropdown = document.getElementById('guides-dropdown');
            
            if (isNowDesktop && mobileMenu && menuOverlay) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('visible');
                menuOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            // Re-initialize dropdown behavior based on new screen size
            const guidesNavItem = document.getElementById('guides-nav-item');
            if (guidesNavItem && guidesDropdown) {
                // Remove previous event listeners (not possible directly, so we'll use other approach)
                if (isNowDesktop) {
                    console.log('Re-initializing desktop dropdown behavior');
                    // Desktop behavior will be handled by the existing event listeners
                } else {
                    // For mobile, ensure dropdown is hidden when switching from desktop
                    if (guidesDropdown.classList.contains('active')) {
                        guidesDropdown.classList.remove('active');
                    }
                }
            }
        }
    });

    console.log('Dropdown fixes loaded successfully');
});

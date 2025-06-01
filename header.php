<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enforce correct site title -->
    <meta property="og:site_name" content="Stallion Signal Pro">
    <title><?php wp_title('|', true, 'right'); ?>Stallion Signal Pro</title>
    <?php wp_head(); ?>
    <style>
        html { scroll-behavior: smooth; }        .gradient-text { background: linear-gradient(90deg, #4f46e5, #818cf8); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .testimonial-slider { transition: transform 0.5s ease-in-out; }
        .nav-link { position: relative; }        .nav-link::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -2px; left: 0; background-color: #4f46e5; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }        .glow { box-shadow: 0 0 15px rgba(79, 70, 229, 0.5); }
        .glow:hover { box-shadow: 0 0 20px rgba(79, 70, 229, 0.8); }        /* Logo glow effect */
        .logo-glow { 
            filter: drop-shadow(0 0 10px rgba(79, 70, 229, 0.7)); 
            transition: filter 0.3s ease-in-out; 
        }
        .logo-glow:hover { 
            filter: drop-shadow(0 0 15px rgba(79, 70, 229, 0.9)); 
        }
        /* Carousel Styles */        .carousel-dot-active { width: 8px !important; height: 8px !important; background-color: white !important; }
        .carousel-slide { transition: all 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        /* Hover Effect for Review Images */
        .review-image-container { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .review-image-container:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }        /* Desktop guides dropdown styling */
        #guides-dropdown {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            margin-top: 0.5rem;
            min-width: 12rem;
            background-color: #1f2937;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 50;
            padding: 0.5rem 0;            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
        }
        #guides-dropdown.active {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        #guides-dropdown a {
            display: block;
            padding: 0.5rem 1rem;
            color: #e5e7eb;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }
        #guides-dropdown a:hover {
            background-color: #2563eb;
            color: white;
            padding-left: 1.25rem;
        }
          /* Mobile guides dropdown */
        #mobile-guides-dropdown {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }
        #mobile-guides-dropdown.active {
            max-height: 8rem; /* Increased to ensure all content fits */
            opacity: 1;
        }
        
        /* Mobile menu improvements */
        #mobile-menu {
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }
        #mobile-menu.visible {
            transform: translateX(0);
        }
        /* Status Messages */
        .status-message { position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; }
        .status-message-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .status-message-error { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .status-message-warning { color: #856404; background-color: #fff3cd; border-color: #ffeeba; }
        .status-message-info { color: #0c5460; background-color: #d1ecf1; border-color: #bee5eb; }
        .notification-container { width: 100%; padding: 0; margin: 0; background: transparent; position: fixed; z-index: 100; top: 64px; }
        .notification-inner { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
    </style>
</head>
<body <?php body_class('bg-gray-900 text-gray-100 font-sans'); ?>>
    <!-- Status Messages -->
    <?php if (isset($_GET['verified']) || isset($_GET['email_resent']) || isset($_GET['login']) && $_GET['login'] === 'failed' || isset($_GET['register']) && $_GET['register'] === 'success'): ?>
    <div class="notification-container">
        <div class="notification-inner">
            <?php if (isset($_GET['verified']) && $_GET['verified'] === 'success'): ?>
                <div class="status-message status-message-success" id="status-message">
                    <strong>Success!</strong> Your email address has been verified. You can now log in.
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            <?php elseif (isset($_GET['verified']) && $_GET['verified'] === 'invalid'): ?>
                <div class="status-message status-message-error" id="status-message">
                    <strong>Error!</strong> The verification link is invalid or has expired. Please try again or contact support.
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            <?php elseif (isset($_GET['email_resent']) && $_GET['email_resent'] === 'success'): ?>
                <div class="status-message status-message-success" id="status-message">
                    <strong>Success!</strong> A new verification email has been sent to your email address.
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            <?php elseif (isset($_GET['email_resent']) && $_GET['email_resent'] === 'error'): ?>
                <div class="status-message status-message-error" id="status-message">
                    <strong>Error!</strong> There was a problem sending the verification email. Please contact support.
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>            <?php elseif (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
                <div class="status-message status-message-success" id="status-message">
                    <strong>Registration successful!</strong> Please check your email for verification instructions.
                    <?php if (isset($_GET['email_sent']) && $_GET['email_sent'] === 'no'): ?>
                        <br>There was an issue sending the verification email. 
                        <a href="<?php echo esc_url(home_url('/verify')); ?>" class="font-bold underline">Click here for manual verification</a>.
                    <?php else: ?>
                        <br>If you don't receive the email, <a href="<?php echo esc_url(home_url('/verify')); ?>" class="font-bold underline">click here for manual verification</a>.
                    <?php endif; ?>
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            <?php elseif (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
                <div class="status-message status-message-error" id="status-message">
                    <strong>Login failed!</strong> Please check your username/email and password, or verify your email first.
                    <button type="button" class="close-notification" style="float: right; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Auto hide notifications after 10 seconds
        setTimeout(function() {
            const statusMessage = document.getElementById('status-message');
            if (statusMessage) {
                statusMessage.style.display = 'none';
            }
        }, 10000);
    </script>
    <?php endif; ?>

    <!-- Navigation -->    <nav class="bg-gray-900 border-b border-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center justify-between h-16">
                <!-- Logo Area -->                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="h-16 logo-glow">
                        </a>
                    </div>
                </div>

                <!-- Desktop Navigation Menu (Centered) -->
                <div class="flex flex-grow items-center justify-center">
                    <ul class="flex items-baseline space-x-4">
                        <li><a href="<?php echo is_front_page() ? '#home' : esc_url(home_url('/')) . '#home'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Home</a></li>
                        <li><a href="<?php echo is_front_page() ? '#about' : esc_url(home_url('/')) . '#about'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">About</a></li>
                        <li><a href="<?php echo is_front_page() ? '#services' : esc_url(home_url('/')) . '#services'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Services</a></li>
                        <li><a href="<?php echo is_front_page() ? '#pricing' : esc_url(home_url('/')) . '#pricing'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Pricing</a></li>
                        <li><a href="<?php echo is_front_page() ? '#faq' : esc_url(home_url('/')) . '#faq'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">FAQ</a></li>
                        <li><a href="<?php echo is_front_page() ? '#contact' : esc_url(home_url('/')) . '#contact'; ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Contact</a></li>                        <li class="relative" id="guides-nav-item">
                            <button id="guides-nav-btn" class="nav-link px-3 py-2 rounded-md text-sm font-medium flex items-center focus:outline-none">
                                Guides <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="guides-dropdown">
                                <a href="<?php echo esc_url(home_url('/guides-crypto')); ?>">Crypto Trading Guide</a>
                                <a href="<?php echo esc_url(home_url('/guides-forex')); ?>">Forex Trading Guide</a>
                            </div>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/academy')); ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Academy</a></li>
                        <?php if (is_user_logged_in()) : ?>
                        <li><a href="<?php echo esc_url(home_url('/profile')); ?>" class="nav-link px-3 py-2 rounded-md text-sm font-medium">Profile</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Desktop Auth Buttons (Right) -->                <div class="flex-shrink-0">
                    <div id="auth-section" class="ml-4 flex items-center md:ml-6">                        <?php if (is_user_logged_in()) : ?>                            <div class="flex items-center space-x-3">
                                <a href="https://t.me/stallionsupport" target="_blank" class="px-3 py-2 text-blue-400 hover:text-blue-300" title="Contact us on Telegram">
                                    <i class="fab fa-telegram text-2xl"></i>
                                </a><a href="<?php echo esc_url(home_url('/profile')); ?>"class="px-3 py-2 text-gray-300 hover:text-white flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-2">
                                        <span class="text-sm font-bold"><?php echo substr(wp_get_current_user()->user_login, 0, 1); ?></span>
                                    </div>
                                    <span class="hidden sm:inline-block">My Account</span>
                                </a>
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="px-4 py-2 rounded-md text-sm font-medium border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-300">Logout</a>
                            </div>
                        <?php else : ?>                            <div class="flex items-center space-x-3">
                                <a href="https://t.me/stallionsupport" target="_blank" class="px-3 py-2 text-blue-400 hover:text-blue-300" title="Contact us on Telegram">
                                    <i class="fab fa-telegram text-2xl"></i>
                                </a>
                                <button id="login-btn" class="px-4 py-2 rounded-md text-sm font-medium border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition duration-300">Login</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
              <!-- Mobile Menu (Hamburger left, logo center, telegram right) -->
            <div class="flex md:hidden items-center justify-between h-16">
                <!-- Left: Mobile menu button -->
                <div class="flex-shrink-0">
                    <button id="mobile-menu-button" class="flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                  <!-- Center: Logo -->                <div class="flex-1 flex justify-center">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="h-12 logo-glow">
                    </a>
                </div>
                  <!-- Right: Telegram icon -->
                <div class="flex-shrink-0">
                    <a href="https://t.me/stallionsupport" target="_blank" class="flex items-center justify-center p-2 text-blue-400 hover:text-blue-300">
                        <i class="fab fa-telegram text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
          <!-- Mobile menu drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-gray-800 fixed top-16 left-0 h-screen w-3/4 shadow-lg z-50 overflow-y-auto">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3"><?php if (is_user_logged_in()) : ?>
                <div class="px-3 py-2 border-b border-gray-700 mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <span><?php echo substr(wp_get_current_user()->user_login, 0, 1); ?></span>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium"><?php echo esc_html(wp_get_current_user()->display_name); ?></div>
                            <div class="text-xs text-gray-400"><?php echo esc_html(wp_get_current_user()->user_email); ?></div>
                        </div>                        <a href="<?php echo esc_url(home_url('/profile')); ?>" class="text-blue-400 hover:text-white">
                            <i class="fas fa-user-circle text-lg"></i>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <a href="<?php echo is_front_page() ? '#home' : esc_url(home_url('/')) . '#home'; ?>" class="block px-3 py-2 rounded-md text-base font-medium border-b border-gray-700">Home</a>
                <a href="<?php echo is_front_page() ? '#about' : esc_url(home_url('/')) . '#about'; ?>" class="block px-3 py-2 rounded-md text-base font-medium border-b border-gray-700">About</a>
                <a href="<?php echo is_front_page() ? '#pricing' : esc_url(home_url('/')) . '#pricing'; ?>" class="block px-3 py-2 rounded-md textbase font-medium border-b border-gray-700">Pricing</a>
                <a href="<?php echo is_front_page() ? '#faq' : esc_url(home_url('/')) . '#faq'; ?>" class="block px-3 py-2 rounded-md textbase font-medium border-b border-gray-700">FAQ</a>
                <a href="<?php echo is_front_page() ? '#contact' : esc_url(home_url('/')) . '#contact'; ?>" class="block px-3 py-2 rounded-md textbase font-medium border-b border-gray-700">Contact</a>                <div class="relative border-b border-gray-700">
                    <button id="mobile-guides-button" class="block w-full text-left px-3 py-2 rounded-md textbase font-medium flex items-center justify-between focus:outline-none">
                        Guides 
                        <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="mobile-guides-dropdown" class="ml-4 overflow-hidden">
                        <a href="<?php echo esc_url(home_url('/guides-crypto')); ?>" class="block px-4 py-2 text-sm text-gray-200 hover:bg-blue-600 hover:text-white rounded-md">Crypto Trading Guide</a>
                        <a href="<?php echo esc_url(home_url('/guides-forex')); ?>" class="block px-4 py-2 text-sm text-gray-200 hover:bg-blue-600 hover:text-white rounded-md">Forex Trading Guide</a>
                    </div>
                </div>
                <a href="<?php echo esc_url(home_url('/academy')); ?>" class="block px-3 py-2 rounded-md textbase font-medium border-b border-gray-700">Academy</a>
                
                <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(home_url('/profile')); ?>" class="block px-3 py-2 rounded-md textbase font-medium border-b border-gray-700">Profile</a>
                <div class="pt-4 pb-3">
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="w-full px-4 py-2 rounded-md textbase font-medium text-center border border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-300 block">Logout</a>
                </div>
                <?php else : ?>
                <div class="pt-4 pb-3">
                    <button id="mobile-login-btn" class="w-full px-4 py-2 rounded-md textbase font-medium border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition duration-300">Login</button>
                </div>
                <?php endif; ?>
            </div>
        </div>    </nav>
    <!-- Login/Profile/Forgot Password Modals will be included here -->
    <?php get_template_part('modals'); ?>
    <script>
        // Add AJAX URL for WordPress
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
</body>
</html>

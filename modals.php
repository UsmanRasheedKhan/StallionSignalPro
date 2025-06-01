<!-- Login Modal -->
<div id="login-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg leading-6 font-medium text-white">Login to your account</h3>
                    <button id="close-login-modal" class="text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>                <div class="mt-5">                    <form id="login-form" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
                        <?php wp_nonce_field('wordpress_login', 'wp_login_nonce'); ?>
                        <input type="hidden" name="redirect_to" id="login-redirect" value="<?php echo esc_url(home_url('/')); ?>">
                        <input type="hidden" name="selected_plan" id="login-selected-plan" value="">
                        
                        <?php if (isset($_GET['login']) && $_GET['login'] == 'failed'): ?>
                            <div id="login-error" class="mb-4 p-3 bg-red-900 text-white text-sm rounded-md">
                                Incorrect username or password. Please try again.
                            </div>
                        <?php elseif (isset($_GET['verified']) && $_GET['verified'] == 'success'): ?>
                            <div id="login-success" class="mb-4 p-3 bg-green-900 text-white text-sm rounded-md">
                                Your account has been verified. You can now log in.
                            </div>
                        <?php else: ?>
                            <div id="login-error" class="hidden mb-4 p-3 bg-red-900 text-white text-sm rounded-md"></div>
                            <div id="login-success" class="hidden mb-4 p-3 bg-green-900 text-white text-sm rounded-md"></div>
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <label for="login-username" class="block text-sm font-medium text-gray-300 mb-1">Username or Email</label>
                            <input type="text" id="login-username" name="log" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div><div class="mb-4">
                            <label for="login-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" id="login-password" name="pwd" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white" data-target="login-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <input id="remember-me" name="rememberme" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-300">Remember me</label>
                            </div>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" id="forgot-password-link" class="text-sm text-blue-400 hover:text-blue-300">Forgot password?</a>
                        </div>
                        <button type="submit" name="wp-submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Sign in
                        </button>
                        <div class="mt-4 text-center text-sm text-gray-300">
                            Don't have an account? <a href="#" id="show-signup-link" class="text-blue-400 hover:text-blue-300">Create one</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Modal -->
<div id="forgot-password-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg leading-6 font-medium text-white">Reset Password</h3>
                    <button id="close-forgot-password-modal" class="text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-5">
                    <form id="forgot-password-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                        <input type="hidden" name="action" value="custom_reset_password">
                        <div id="forgot-password-message" class="hidden mb-4 p-3 rounded-md text-sm"></div>
                        <div class="mb-4">
                            <label for="forgot-username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                            <input type="text" id="forgot-username" name="user_login" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="forgot-email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                            <input type="email" id="forgot-email" name="user_email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="forgot-password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                            <div class="relative">
                                <input type="password" id="forgot-password" name="new_password" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required minlength="8">
                                <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white" data-target="forgot-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="forgot-password-strength" class="mt-1 text-xs">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-600 rounded-full h-1.5">
                                        <div id="forgot-password-strength-meter" class="h-1.5 rounded-full bg-red-500" style="width: 0%"></div>
                                    </div>
                                    <span id="forgot-password-strength-text" class="ml-2 text-gray-400">Weak</span>
                                </div>
                            </div>
                            <div id="forgot-password-requirements" class="mt-1 text-xs text-gray-400">
                                Password must:
                                <ul class="list-disc pl-4 space-y-1 mt-1">
                                    <li id="forgot-req-length" class="text-red-400">Be at least 8 characters</li>
                                    <li id="forgot-req-uppercase" class="text-red-400">Include uppercase letter</li>
                                    <li id="forgot-req-lowercase" class="text-red-400">Include lowercase letter</li>
                                    <li id="forgot-req-number" class="text-red-400">Include number</li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Signup Modal -->
<div id="signup-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg leading-6 font-medium text-white">Create an account</h3>
                    <button id="close-signup-modal" class="text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>                <div class="mt-5">
                    <form id="signup-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                        <input type="hidden" name="action" value="custom_register_user">
                        <input type="hidden" name="is_ajax" value="true" id="is-ajax-register">
                        <?php wp_nonce_field('custom_register_nonce', 'custom_register_nonce'); ?>
                        <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/')); ?>">
                        <div class="mb-4">
                            <label for="signup-username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                            <input type="text" id="signup-username" name="user_login" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="signup-name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                            <input type="text" id="signup-name" name="display_name" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="signup-email" class="block text-sm font-medium text-gray-300 mb-1">Email (Gmail, Outlook, or Yahoo only)</label>
                            <input type="email" id="signup-email" name="user_email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div id="email-validation-error" class="hidden text-red-400 text-xs mt-1">Please use an email address from Gmail, Outlook, or Yahoo mail services only.</div>
                            <div class="text-gray-400 text-xs mt-1">Only email addresses from Gmail, Outlook, and Yahoo are currently supported.</div>
                        </div>
                        <div class="mb-4">                                <label for="signup-password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                                <div class="relative">
                                    <input type="password" id="signup-password" name="user_pass" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required minlength="8">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white" data-target="signup-password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="password-strength" class="mt-1 text-xs">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-600 rounded-full h-1.5">
                                            <div id="password-strength-meter" class="h-1.5 rounded-full bg-red-500" style="width: 0%"></div>
                                        </div>
                                        <span id="password-strength-text" class="ml-2 text-gray-400">Weak</span>
                                    </div>
                                </div>
                                <div id="password-requirements" class="mt-1 text-xs text-gray-400">
                                    Password must:
                                    <ul class="list-disc pl-4 space-y-1 mt-1">
                                        <li id="req-length" class="text-red-400">Be at least 8 characters</li>
                                        <li id="req-uppercase" class="text-red-400">Include uppercase letter</li>
                                        <li id="req-lowercase" class="text-red-400">Include lowercase letter</li>
                                        <li id="req-number" class="text-red-400">Include number</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mb-4">                                <label for="signup-password-confirm" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" id="signup-password-confirm" name="user_pass_confirm" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required minlength="8">
                                    <button type="button" class="password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white" data-target="signup-password-confirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="password-match-error" class="hidden text-red-400 text-xs mt-1">Passwords do not match</div>
                            </div>
                            <div id="signup-error" class="hidden mb-4 p-2 bg-red-900 text-white text-sm rounded-md"></div>                            <div id="signup-success" class="hidden mb-4 p-4 bg-green-900 text-white text-sm rounded-md">
                                <!-- Success message content will be dynamically generated in auth-fix.js -->
                            </div>
                            <button type="submit" name="wp-submit" id="signup-submit-btn" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Register
                            </button>
                            <div class="mt-4 text-center text-sm text-gray-300">
                                Already have an account? <a href="#" id="show-login-link" class="text-blue-400 hover:text-blue-300">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg leading-6 font-medium text-white">My Account</h3>
                    <button id="close-profile-modal" class="text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-5">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center mb-4">
                            <i class="fas fa-user text-white text-3xl"></i>
                        </div>
                        <?php if (is_user_logged_in()): 
                            $current_user = wp_get_current_user();
                        ?>
                            <div class="text-white font-bold text-xl mb-1"><?php echo esc_html($current_user->display_name); ?></div>
                            <div class="text-gray-400 text-md mb-4"><?php echo esc_html($current_user->user_email); ?></div>
                            
                            <?php
                            $subscription_status = get_user_meta($current_user->ID, 'subscription_status', true) ?: 'inactive';
                            $subscription_plan = get_user_meta($current_user->ID, 'subscription_plan', true) ?: 'none';
                            ?>
                            
                            <div class="w-full bg-gray-700 rounded-lg p-4 mb-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-300">Subscription:</span>
                                    <span class="font-medium"><?php echo ucfirst(esc_html($subscription_plan)); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-300">Status:</span>
                                    <span class="<?php echo $subscription_status === 'active' ? 'text-green-400' : 'text-red-400'; ?>"><?php echo ucfirst(esc_html($subscription_status)); ?></span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full mb-4">
                                <a href="<?php echo esc_url(home_url('/profile')); ?>" class="px-4 py-2 rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition duration-300 text-center">
                                    <i class="fas fa-user-circle mr-1"></i> Full Profile
                                </a>
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="px-4 py-2 rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-700 transition duration-300 text-center">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-white font-bold text-lg mb-2">Not logged in</div>
                            <button id="modal-login-btn" class="mt-4 px-4 py-2 rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition duration-300">Login</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forgotForm = document.getElementById('forgot-password-form');
    const forgotMsg = document.getElementById('forgot-password-message');
    if (forgotForm && forgotMsg) {
        forgotForm.addEventListener('submit', function(e) {
            e.preventDefault();
            forgotMsg.classList.add('hidden');
            forgotMsg.textContent = '';
            forgotMsg.className = 'hidden mb-4 p-3 rounded-md text-sm';
            const formData = new FormData(forgotForm);
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                forgotMsg.textContent = data.message || 'Unknown error.';
                forgotMsg.classList.remove('hidden');
                if (data.success) {
                    forgotMsg.classList.add('bg-green-800', 'text-green-200');
                    forgotMsg.classList.remove('bg-red-800', 'text-red-200');
                    forgotForm.reset();
                } else {
                    forgotMsg.classList.add('bg-red-800', 'text-red-200');
                    forgotMsg.classList.remove('bg-green-800', 'text-green-200');
                }
            })
            .catch(() => {
                forgotMsg.textContent = 'An error occurred. Please try again.';
                forgotMsg.classList.remove('hidden');
                forgotMsg.classList.add('bg-red-800', 'text-red-200');
            });
        });
    }
});
</script>

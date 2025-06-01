<?php
/*
Template Name: Manual Verification Page
*/
get_header();

// Process manual verification if form is submitted
$message = '';
$error = '';
$success = false;

if (isset($_POST['verify_user'])) {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    
    // Try to find user by username or email
    $user = get_user_by('login', $username);
    if (!$user) {
        $user = get_user_by('email', $email);
    }
      if ($user) {
        // Check if user is already verified
        $verified = get_user_meta($user->ID, 'email_verified', true);
        $is_admin = user_can($user->ID, 'manage_options') || user_can($user->ID, 'edit_pages');
        
        if ($verified === '1') {
            $message = "This account is already verified. You can login now.";
            if ($is_admin) {
                $message .= " As an administrator, your account automatically bypasses verification.";
            }
            $success = true;
        } else {
            // Manually verify the user
            update_user_meta($user->ID, 'email_verified', 1);
            update_user_meta($user->ID, 'account_status', 'active');
            delete_user_meta($user->ID, 'account_activation_key');
            
            $message = "Account successfully verified! You can now log in.";
            if ($is_admin) {
                $message .= " As an administrator, your account will always bypass verification in the future.";
            }
            $success = true;
        }
    } else {
        $error = "User not found. Please check your username or email address.";
    }
}
?>

<!-- Manual Verification Page Content -->
<div class="py-32 px-4 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Account Verification</h1>
    
    <div class="bg-gray-800 p-8 rounded-lg shadow-md">
        <div class="p-4 mb-6 bg-blue-800 text-white rounded-md">
            <h2 class="text-xl font-bold mb-2">⚠️ Manual Verification Required</h2>
            <p>Due to technical difficulties with our email system, all new accounts need to verify manually using the form below.</p>
        </div>
        <p class="mb-6 text-gray-300">
            Please enter the username and email address you used during registration to verify your account.
        </p>
          <?php if ($message): ?>
            <div class="p-4 mb-6 rounded-md <?php echo $success ? 'bg-green-800 text-green-200' : 'bg-red-800 text-red-200'; ?>">
                <?php if ($success): ?>
                    <div class="flex items-start">
                        <div class="mr-3 pt-1">
                            <svg class="w-6 h-6 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Verification Successful!</h3>
                            <p class="mt-1"><?php echo esc_html($message); ?></p>
                            <div class="mt-3">                                <a href="<?php echo esc_url(home_url('/')); ?>" id="login-after-verify" class="inline-block px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-md transition">
                                    Login to Your Account
                                </a>
                                <script>
                                    document.getElementById('login-after-verify').addEventListener('click', function(e) {
                                        e.preventDefault();
                                        // Store a flag in session storage to show login modal on homepage
                                        sessionStorage.setItem('showLoginModal', 'true');
                                        window.location.href = '<?php echo esc_url(home_url('/')); ?>';
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php echo esc_html($message); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="p-4 mb-6 bg-red-800 text-red-200 rounded-md">
                <div class="flex items-start">
                    <div class="mr-3 pt-1">
                        <svg class="w-6 h-6 text-red-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Verification Error</h3>
                        <p class="mt-1"><?php echo esc_html($error); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
          <form method="post" action="">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                <input type="text" id="username" name="username" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            
            <!-- Auto-populate fields from session storage if available -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Check for stored username and email from registration
                    const storedUsername = sessionStorage.getItem('verifyUsername');
                    const storedEmail = sessionStorage.getItem('verifyEmail');
                    
                    // Populate form fields if values exist
                    if (storedUsername) {
                        document.getElementById('username').value = storedUsername;
                    }
                    
                    if (storedEmail) {
                        document.getElementById('email').value = storedEmail;
                    }
                    
                    // Clear the session storage after using the values
                    if (storedUsername || storedEmail) {
                        // But only clear them after form submission to prevent losing the data if page is refreshed
                        document.querySelector('form').addEventListener('submit', function() {
                            sessionStorage.removeItem('verifyUsername');
                            sessionStorage.removeItem('verifyEmail');
                        });
                    }
                });
            </script>
            
            <button type="submit" name="verify_user" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition duration-300">
                Verify My Account
            </button>
        </form>
        
        <div class="mt-6 border-t border-gray-700 pt-6">
            <h2 class="text-xl font-semibold mb-4">Troubleshooting</h2>
            <ul class="list-disc pl-5 space-y-2 text-gray-300">
                <li>Make sure you've entered the same username and email you used during registration.</li>
                <li>Check your spam or junk folder for the verification email.</li>
                <li>If you still can't verify your account, please contact our support team.</li>
            </ul>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-indigo-400 hover:text-indigo-300">
            &larr; Return to Home
        </a>
    </div>
</div>

<?php get_footer(); ?>

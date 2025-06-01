<?php
// Custom authentication functions
function stallion_handle_login_form() {
    // Check if the form was submitted
    if (!isset($_POST['wp_login_nonce']) || !wp_verify_nonce($_POST['wp_login_nonce'], 'wordpress_login')) {
        return;
    }
    
    $credentials = array(
        'user_login'    => $_POST['log'],
        'user_password' => $_POST['pwd'],
        'remember'      => isset($_POST['rememberme']),
    );
    
    $user = wp_signon($credentials, is_ssl());
    
    if (is_wp_error($user)) {
        // If there's an error, redirect back to the login form
        wp_redirect(home_url('/?login=failed'));
        exit;
    } else {
        // If successful, redirect to the homepage or specified redirect URL
        $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : home_url();
        wp_redirect($redirect_to);
        exit;
    }
}
add_action('init', 'stallion_handle_login_form');

function stallion_handle_registration_form() {
    // Check if the form was submitted
    if (!isset($_POST['wp_register_nonce']) || !wp_verify_nonce($_POST['wp_register_nonce'], 'wordpress_register')) {
        return;
    }
    
    $username = sanitize_user($_POST['user_login']);
    $email = sanitize_email($_POST['user_email']);
    
    // Register the user
    $result = register_new_user($username, $email);
    
    if (is_wp_error($result)) {
        // If there's an error, redirect back to the registration form
        wp_redirect(home_url('/?registration=failed'));
        exit;
    } else {
        // If successful, redirect to the homepage with a success message
        wp_redirect(home_url('/?registration=success'));
        exit;
    }
}
add_action('init', 'stallion_handle_registration_form');

// Add AJAX endpoint for registration
function stallion_ajax_register_user() {
    check_ajax_referer('custom_register_nonce', 'custom_register_nonce');
    
    // Call the custom registration function which will handle everything
    stallion_custom_register_user();
    
    // The function above will either exit with wp_send_json or redirect
    exit;
}
add_action('wp_ajax_nopriv_custom_register_user', 'stallion_ajax_register_user');
add_action('wp_ajax_custom_register_user', 'stallion_ajax_register_user');

// Handle AJAX password reset requests
function stallion_ajax_reset_password() {
    $response = array('success' => false);
    
    if (isset($_POST['user_login'])) {
        $user_login = sanitize_text_field($_POST['user_login']);
        
        // Try to identify user by email or username
        $user_data = get_user_by('email', $user_login);
        if (!$user_data) {
            $user_data = get_user_by('login', $user_login);
        }
        
        if ($user_data) {
            // Generate a password reset key
            $key = get_password_reset_key($user_data);
            
            if (!is_wp_error($key)) {
                // Build the reset URL
                $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_data->user_login), 'login');
                
                // Email subject
                $subject = sprintf(__('[%s] Password Reset'), get_bloginfo('name'));
                
                // Email message
                $message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
                $message .= sprintf(__('Site Name: %s'), get_bloginfo('name')) . "\r\n\r\n";
                $message .= sprintf(__('Username: %s'), $user_data->user_login) . "\r\n\r\n";
                $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
                $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
                $message .= $reset_url . "\r\n\r\n";
                  // Send the email using our enhanced mail function if available
                $mail_sent = false;
                if (function_exists('stallion_enhanced_mail')) {
                    $headers = array(
                        'Content-Type: text/plain; charset=UTF-8',
                        'From: ' . get_bloginfo('name') . ' <murkssayings@gmail.com>',
                        'Reply-To: murkssayings@gmail.com'
                    );
                    $mail_sent = stallion_enhanced_mail($user_data->user_email, $subject, $message, $headers);
                } else {
                    $mail_sent = wp_mail($user_data->user_email, $subject, $message);
                }
                
                // Record email sending success or failure for verification status tracking
                if ($mail_sent) {
                    stallion_record_verification_success();
                    $response['success'] = true;
                    $response['message'] = 'Password reset link has been sent to your email address.';
                } else {
                    stallion_record_verification_failure();
                    $response['success'] = false;
                    $response['message'] = 'There was an error sending the password reset email. Please try again later or contact support.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'There was an error generating the password reset link. Please try again later.';
            }
        } else {
            // Always return success to prevent user enumeration
            $response['success'] = true;
            $response['message'] = 'If your email or username exists in our database, you will receive a password reset link at your email address.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Please provide a username or email address.';
    }
    
    wp_send_json($response);
    exit;
}
add_action('wp_ajax_nopriv_reset_password', 'stallion_ajax_reset_password');
add_action('wp_ajax_reset_password', 'stallion_ajax_reset_password');
?>

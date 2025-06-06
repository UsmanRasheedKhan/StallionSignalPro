<?php
// Theme functions for Stallion Signal Pro

// DEBUG: Confirm functions.php is loaded
add_action('admin_notices', function() {
    echo '<div class="notice notice-info"><p>functions.php is loaded</p></div>';
});

// Include authentication functions
require_once get_template_directory() . '/auth-functions.php';

// Include SMTP helper functions
require_once get_template_directory() . '/smtp-helper.php';

// Include email domain validation
require_once get_template_directory() . '/email-domains.php';

// Include verification status checker
require_once get_template_directory() . '/verification-status.php';

// Fix the site name to ensure it's "Stallion Signal Pro" (overrides possible database misspelling)
function stallion_fix_site_name($name) {
    return 'Stallion Signal Pro';
}
add_filter('option_blogname', 'stallion_fix_site_name');

// Custom page title filter to ensure "Stallion Signal Pro" is in the title
function stallion_custom_page_title($title) {
    if (empty($title)) {
        return 'Stallion Signal Pro';
    } else {
        return $title . ' | Stallion Signal Pro';
    }
}
add_filter('wp_title', 'stallion_custom_page_title');

// Configure SMTP email settings
function stallion_configure_smtp($phpmailer) {
    // Replace these with your SMTP server details
    $phpmailer->isSMTP();                      // Set mailer to use SMTP
    $phpmailer->Host = 'smtp.gmail.com';       // Specify SMTP server (example: Gmail)
    $phpmailer->SMTPAuth = true;               // Enable SMTP authentication
    $phpmailer->Port = 587;                    // TCP port to connect to
    $phpmailer->Username = 'murkssayings@gmail.com'; // SMTP username
    $phpmailer->Password = 'cvfvhrfwfzlvcfnr'; // SMTP password (app password for Gmail with spaces removed)
    $phpmailer->SMTPSecure = 'tls';            // Enable TLS encryption
    $phpmailer->From = 'murkssayings@gmail.com'; // Sender email
    $phpmailer->FromName = get_bloginfo('name'); // Sender name
    
    // Add debug settings
    $phpmailer->SMTPDebug = 1;                // Enable debugging (1 for client messages, 2 for client and server messages)
    $phpmailer->Debugoutput = 'error_log';    // Send debug output to error log
}
add_action('phpmailer_init', 'stallion_configure_smtp');

// Debugging email issues
function stallion_log_mailer_errors($wp_error) {
    $log_file = get_template_directory() . '/email-errors.log';
    $timestamp = date('Y-m-d H:i:s');
    $message = $timestamp . ' - Mailer Error: ' . $wp_error->get_error_message() . "\n";
    error_log($message, 3, $log_file);
    
    // Also log to PHP error log for easier debugging
    error_log('WordPress Mail Error: ' . $wp_error->get_error_message());
    
    // Save detailed error data
    $error_data = $wp_error->get_error_data();
    if (!empty($error_data)) {
        $data_message = $timestamp . " - Error Data: " . print_r($error_data, true) . "\n";
        error_log($data_message, 3, $log_file);
    }
}
add_action('wp_mail_failed', 'stallion_log_mailer_errors');

// Add a test email function that can be called from admin dashboard
function stallion_test_email() {
    if (current_user_can('manage_options') && isset($_GET['test_mail']) && $_GET['test_mail'] == '1') {
        $to = get_option('admin_email');
        $subject = 'SMTP Test Email';
        $message = 'This is a test email to verify that your SMTP configuration is working correctly.';
        
        $result = wp_mail($to, $subject, $message);
          echo '<div class="notice notice-' . ($result ? 'success' : 'error') . ' is-dismissible">';
        echo '<p>' . ($result ? 'Test email sent successfully!' : 'Failed to send test email. Check error logs.') . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'stallion_test_email');

function stallion_enqueue_scripts() {
    // Temporarily use TailwindCSS CDN for development
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false);
    // Enqueue Font Awesome
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');    // Enqueue theme stylesheet (style.css for custom styles)
    wp_enqueue_style('stallion-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));
    // Enqueue custom JS (main.js)    wp_enqueue_script('stallion-main', get_template_directory_uri() . '/main.js', array('jquery'), filemtime(get_template_directory() . '/main.js'), true);    // Enqueue dropdown fixes
    wp_enqueue_script('stallion-dropdown-fixes', get_template_directory_uri() . '/dropdown-fixes.js', array('jquery'), time(), true);
    // Enqueue image slider fix
    wp_enqueue_script('stallion-slider-fix', get_template_directory_uri() . '/slider-fix.js', array('jquery'), time(), true);    // Enqueue FAQ fix
    wp_enqueue_script('stallion-faq-fix', get_template_directory_uri() . '/faq-fix.js', array('jquery'), time(), true);    // Enqueue auth fix for login modal issue
    wp_enqueue_script('stallion-auth-fix', get_template_directory_uri() . '/auth-fix.js', array('jquery'), time(), true);
    
    // Enqueue form messages handler
    wp_enqueue_script('stallion-form-messages', get_template_directory_uri() . '/js/form-messages.js', array('jquery'), time(), true);
    // Localize script to pass WordPress data to JS
    wp_localize_script('stallion-main', 'stallionData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'homeUrl' => home_url(),
        'isLoggedIn' => is_user_logged_in()
    ));
}
add_action('wp_enqueue_scripts', 'stallion_enqueue_scripts');

// Register navigation menu
function stallion_register_menus() {
    register_nav_menus([
        'main_menu' => __('Main Menu', 'stallion')
    ]);
}
add_action('after_setup_theme', 'stallion_register_menus');

// Support WordPress native registration
function stallion_custom_user_registration() {
    // Enable user registration
    add_action('init', function() {
        add_option('users_can_register', 1);
    });
}
add_action('after_setup_theme', 'stallion_custom_user_registration');

// Theme support
function stallion_theme_support() {
    // Add theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'stallion_theme_support');

// Add cache busting for theme files
function stallion_cache_bust_on_theme_change() {
    // Force reload of CSS and JS files when modified
    $styles_version = filemtime(get_stylesheet_directory() . '/style.css');
    $scripts_version = filemtime(get_template_directory() . '/main.js');
    
    // Optional: Add to the admin bar a clear cache button
    if (is_admin_bar_showing() && current_user_can('manage_options')) {
        global $wp_admin_bar;
        $wp_admin_bar->add_menu(array(
            'id' => 'clear-theme-cache',
            'title' => 'Clear Theme Cache',
            'href' => '#',
            'meta' => array(
                'onclick' => 'jQuery(document).ready(function($) {
                    // Force reload without cache
                    location.reload(true);
                }); return false;',
            )
        ));
    }
}
add_action('wp_head', 'stallion_cache_bust_on_theme_change');

// Process contact form submissions
function stallion_process_contact_form() {
    if (isset($_POST['contact_form_nonce']) && wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_nonce')) {
        // Get form data
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $subject = sanitize_text_field($_POST['contact_subject']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        $date = current_time('mysql');
        
        // Insert into database as a custom post type
        $post_data = array(
            'post_title'    => 'Contact from ' . $name . ' - ' . $subject,
            'post_content'  => $message,
            'post_status'   => 'private',
            'post_type'     => 'contact_message',
            'post_author'   => 1, // Default admin user
            'meta_input'    => array(
                'contact_name' => $name,
                'contact_email' => $email,
                'contact_subject' => $subject,
            ),
        );
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Send email notification to admin
            $admin_email = get_option('admin_email');
            $site_name = get_bloginfo('name');
            $admin_subject = '[' . $site_name . '] New Contact Form Submission';
            $admin_message = "You have received a new contact form submission:\n\n";
            $admin_message .= "Name: $name\n";
            $admin_message .= "Email: $email\n";
            $admin_message .= "Subject: $subject\n";
            $admin_message .= "Message:\n$message\n\n";
            $admin_message .= "You can view this message in your WordPress admin area.";
            
            wp_mail($admin_email, $admin_subject, $admin_message);
            
            // Send confirmation email to user
            $user_subject = 'Thank you for contacting ' . $site_name;
            $user_message = "Dear $name,\n\n";
            $user_message .= "Thank you for reaching out to us. We have received your message and will respond shortly.\n\n";
            $user_message .= "Here's a copy of your message:\n\n";
            $user_message .= "Subject: $subject\n";
            $user_message .= "Message:\n$message\n\n";
            $user_message .= "Best regards,\n";
            $user_message .= "The team at " . $site_name;
            
            wp_mail($email, $user_subject, $user_message);
            
            // Redirect back with success
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
            exit;
        } else {
            // Redirect back with error
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
    } else {
        // Nonce verification failed
        wp_redirect(add_query_arg('contact', 'error', home_url()));
        exit;
    }
}
add_action('admin_post_process_contact_form', 'stallion_process_contact_form');
add_action('admin_post_nopriv_process_contact_form', 'stallion_process_contact_form');

// Register Contact Message Custom Post Type
function stallion_register_contact_message_cpt() {
    $args = array(
        'labels' => array(
            'name'               => 'Contact Messages',
            'singular_name'      => 'Contact Message',
            'menu_name'          => 'Contact Messages',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Contact Message',
            'edit_item'          => 'Edit Contact Message',
            'new_item'           => 'New Contact Message',
            'view_item'          => 'View Contact Message',
            'search_items'       => 'Search Contact Messages',
            'not_found'          => 'No contact messages found',
            'not_found_in_trash' => 'No contact messages found in trash',
        ),
        'public'              => false,
        'show_ui'             => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => false,
        'supports'            => array('title', 'editor'),
        'has_archive'         => false,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-email-alt',
    );    register_post_type('contact_message', $args);
}
add_action('init', 'stallion_register_contact_message_cpt');

// Add meta boxes for contact message details
function stallion_contact_message_meta_boxes() {
    add_meta_box(
        'contact_details',
        'Contact Details',        'stallion_contact_details_meta_box',
        'contact_message',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'stallion_contact_message_meta_boxes');

// Display contact details meta box
function stallion_contact_details_meta_box($post) {
    $name = get_post_meta($post->ID, 'contact_name', true);
    $email = get_post_meta($post->ID, 'contact_email', true);
    $subject = get_post_meta($post->ID, 'contact_subject', true);
    
    echo '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
    echo '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
    echo '<p><strong>Subject:</strong> ' . esc_html($subject) . '</p>';
}

// Custom User Registration with Email Verification
function stallion_custom_register_user() {
    if (isset($_POST['custom_register_nonce']) && wp_verify_nonce($_POST['custom_register_nonce'], 'custom_register_nonce')) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $display_name = isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '';
        $password = $_POST['user_pass'];
        $confirm_password = $_POST['user_pass_confirm'];
        
        $is_ajax = isset($_POST['is_ajax']) && $_POST['is_ajax'] == 'true';
        $response = array('success' => false);
        
        // --- DEBUG LOGGING FOR REGISTRATION ERRORS ---
function stallion_log_registration_error($message, $data = []) {
    $log_file = get_template_directory() . '/registration-errors.log';
    $entry = date('Y-m-d H:i:s') . ' - ' . $message;
    if (!empty($data)) {
        $entry .= ' | ' . print_r($data, true);
    }
    file_put_contents($log_file, $entry . "\n", FILE_APPEND);
}
        
        // Check if passwords match
        if ($password !== $confirm_password) {
            stallion_log_registration_error('Password mismatch', $_POST);
            if ($is_ajax) {
                $response['error'] = 'password_mismatch';
                $response['message'] = 'Passwords do not match.';
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'password_mismatch'), wp_get_referer()));
                exit;
            }
        }
        // Password strength validation
        if (strlen($password) < 8) {
            stallion_log_registration_error('Weak password', $_POST);
            if ($is_ajax) {
                $response['error'] = 'weak_password';
                $response['message'] = 'Password must be at least 8 characters long.';
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'weak_password'), wp_get_referer()));
                exit;
            }
        }
        // Validate password strength (must contain at least one uppercase, one lowercase and one number)
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            stallion_log_registration_error('Weak password (pattern)', $_POST);
            if ($is_ajax) {
                $response['error'] = 'weak_password';
                $response['message'] = 'Password must include at least one uppercase letter, one lowercase letter, and one number.';
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'weak_password', 'message' => urlencode('Password must include at least one uppercase letter, one lowercase letter, and one number.')), wp_get_referer()));
                exit;
            }
        }
        // Check if email exists
        if (email_exists($email)) {
            stallion_log_registration_error('Email exists', $_POST);
            if ($is_ajax) {
                $response['error'] = 'email_exists';
                $response['message'] = 'This email address is already registered.';
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'email_exists'), wp_get_referer()));
                exit;
            }
        }
        // Validate email domain
        if (!stallion_is_valid_email_domain($email)) {
            stallion_log_registration_error('Invalid email domain', $_POST);
            if ($is_ajax) {
                $response['error'] = 'invalid_email_domain';
                $response['message'] = stallion_get_invalid_email_message();
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'invalid_email_domain', 'message' => urlencode(stallion_get_invalid_email_message())), wp_get_referer()));
                exit;
            }
        }
        // Create user
        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            stallion_log_registration_error('Registration error', $user_id->get_error_message());
            if ($is_ajax) {
                $response['error'] = 'registration_error';
                $response['message'] = $user_id->get_error_message();
                wp_send_json($response);
                exit;
            } else {
                wp_redirect(add_query_arg(array('register' => 'error', 'message' => urlencode($user_id->get_error_message())), wp_get_referer()));
                exit;
            }
        }
        // Set user role
        $user = new WP_User($user_id);
        $user->set_role('subscriber');
        if ($display_name) {
            wp_update_user(array('ID' => $user_id, 'display_name' => $display_name));
        }
        // Immediately log in the user
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        
        // For AJAX request
        if ($is_ajax) {
            $response['success'] = true;
            $response['username'] = $username;
            $response['email'] = $email;
            $response['message'] = 'Registration successful! You are now logged in.';
            $response['redirect'] = true;
            $response['redirect_url'] = home_url('/');
            wp_send_json($response);
            exit;
        } else {
            wp_redirect(home_url('/'));
            exit;
        }
    } else {
        wp_redirect(home_url('/'));
        exit;
    }
}
add_action('admin_post_custom_register_user', 'stallion_custom_register_user');
add_action('admin_post_nopriv_custom_register_user', 'stallion_custom_register_user');
// AJAX handlers for registration
add_action('wp_ajax_custom_register_user', 'stallion_custom_register_user');
add_action('wp_ajax_nopriv_custom_register_user', 'stallion_custom_register_user');

// Email verification handler
function stallion_verify_email() {
    // Handle verification email
    if (isset($_GET['action']) && $_GET['action'] === 'verify_email' && isset($_GET['user_id']) && isset($_GET['key'])) {
        $user_id = intval($_GET['user_id']);
        $key = $_GET['key'];
        $stored_key = get_user_meta($user_id, 'account_activation_key', true);
        if ($stored_key === $key && !empty($key)) {
            // Verify the user's email
            update_user_meta($user_id, 'email_verified', 1);
            update_user_meta($user_id, 'account_status', 'active');
            delete_user_meta($user_id, 'account_activation_key'); // Expire the key after use
            wp_redirect(add_query_arg(array('verified' => 'success'), home_url('/')));
            exit;
        } else {
            wp_redirect(add_query_arg(array('verified' => 'invalid'), home_url('/')));
            exit;
        }
    }
      // Handle resend verification email request
    if (isset($_GET['action']) && $_GET['action'] === 'resend_verification' && isset($_GET['user'])) {
        $user_hash = $_GET['user'];
        $user_id = get_transient('pending_verification_' . $user_hash);
        
        if ($user_id) {
            $user_data = get_userdata($user_id);
            $username = $user_data->user_login;
            $email = $user_data->user_email;
            
            // Generate new activation key
            $activation_key = wp_generate_password(20, false);
            update_user_meta($user_id, 'account_activation_key', $activation_key);
            
            // Send verification email
            $verify_url = add_query_arg(array(
                'action' => 'verify_email',
                'user_id' => $user_id,
                'key' => $activation_key
            ), home_url('/'));
            
            $subject = 'Verify your account - ' . get_bloginfo('name');
            $message = "Hi $username,\n\n";
            $message .= "You requested a new verification email for " . get_bloginfo('name') . ".\n\n";
            $message .= "Please click the link below to verify your email address and activate your account:\n\n";
            $message .= $verify_url . "\n\n";
            $message .= "This link will expire in 24 hours.\n\n";
            $message .= "If you did not request this email, please ignore it.\n\n";
            $message .= "If you're still having trouble, you can manually verify your account at: " . home_url('/verify') . "\n\n";
            $message .= "Best regards,\n";
            $message .= get_bloginfo('name') . " Team";
            
            // Use enhanced mail function if available
            if (function_exists('stallion_enhanced_mail')) {
                $headers = array(
                    'Content-Type: text/plain; charset=UTF-8',
                    'From: ' . get_bloginfo('name') . ' <murkssayings@gmail.com>',
                    'Reply-To: murkssayings@gmail.com'
                );
                $mail_sent = stallion_enhanced_mail($email, $subject, $message, $headers);
            } else {
                $mail_sent = wp_mail($email, $subject, $message);
            }
            
            // Log the email sending attempt
            error_log("Verification email resend attempt to {$email}: " . ($mail_sent ? 'Success' : 'Failed'), 0);
            
            if (!$mail_sent) {
                // If email sending fails, redirect to manual verification page
                wp_redirect(home_url('/verify'));
                exit;
            }
            
            wp_redirect(add_query_arg(array('email_resent' => $mail_sent ? 'success' : 'error'), home_url('/')));
            exit;
        } else {
            wp_redirect(add_query_arg(array('email_resent' => 'expired'), home_url('/')));
            exit;
        }
    }
}
add_action('init', 'stallion_verify_email');

// Check if email is verified before login
function stallion_check_email_verified($user, $username, $password) {
    $user_obj = get_user_by('login', $username);
    if (!$user_obj) {
        $user_obj = get_user_by('email', $username);
    }
    if ($user_obj) {
        // Bypass for admins and editors
        if (user_can($user_obj->ID, 'manage_options') || user_can($user_obj->ID, 'edit_pages')) {
            if (get_user_meta($user_obj->ID, 'email_verified', true) !== '1') {
                update_user_meta($user_obj->ID, 'email_verified', '1');
                update_user_meta($user_obj->ID, 'account_status', 'active');
                error_log("Admin user {$username} (ID: {$user_obj->ID}) was automatically verified by the system bypass.");
            }
            return $user;
        }
        // Only allow login if verified
        $verified = get_user_meta($user_obj->ID, 'email_verified', true);
        if ($verified !== '1') {
            set_transient('pending_verification_' . md5($username), $user_obj->ID, 60 * 60 * 24); // 24 hours
            return new WP_Error(
                'email_not_verified', 
                __('Please verify your email address before logging in. Check your email for the verification link or <a href="?action=resend_verification&user=' . md5($username) . '">click here to resend the verification email</a>.<br><br>Having trouble? <a href="' . home_url('/verify') . '">Click here for manual verification</a>.')
            );
        }
    }
    return $user;
}
add_filter('authenticate', 'stallion_check_email_verified', 30, 3);

// Register Payment Proof Custom Post Type
function stallion_register_payment_proof_cpt() {
    $args = array(
        'labels' => array(
            'name'               => 'Payment Proofs',
            'singular_name'      => 'Payment Proof',
            'menu_name'          => 'Payment Proofs',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Payment Proof',
            'edit_item'          => 'Edit Payment Proof',
            'new_item'           => 'New Payment Proof',
            'view_item'          => 'View Payment Proof',
            'search_items'       => 'Search Payment Proofs',
            'not_found'          => 'No payment proofs found',
            'not_found_in_trash' => 'No payment proofs found in trash',
        ),
        'public'              => false,
        'show_ui'             => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => false,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'has_archive'         => false,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-money-alt',
    );    register_post_type('payment_proof', $args);
}
add_action('init', 'stallion_register_payment_proof_cpt');

// Add meta boxes for payment proof details
function stallion_payment_proof_meta_boxes() {
    add_meta_box(
        'payment_proof_details',
        'Payment Details',
        'stallion_payment_proof_details_meta_box',
        'payment_proof',
        'side',
        'high'
    );
    
    add_meta_box(
        'payment_proof_actions',
        'Payment Actions',
        'stallion_payment_proof_actions_meta_box',
        'payment_proof',
        'side',
        'high'
    );
    
    add_meta_box(
        'payment_proof_image_display',
        'Payment Proof Image',
        'stallion_payment_proof_image_display_meta_box',
        'payment_proof',
        'normal',
        'high'
    );
}

// Display payment proof image in a dedicated meta box
function stallion_payment_proof_image_display_meta_box($post) {
    // Get the featured image ID and display it directly
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $payment_proof_id = get_post_meta($post->ID, 'payment_proof_image', true);
    
    if ($thumbnail_id || $payment_proof_id) {
        $image_id = $thumbnail_id ? $thumbnail_id : $payment_proof_id;
        $image_url = wp_get_attachment_url($image_id);
        $large_image_url = wp_get_attachment_image_src($image_id, 'full');
        if ($large_image_url) {
            $large_image_url = $large_image_url[0];
        } else {
            $large_image_url = $image_url;
        }
        
        echo '<div style="text-align: center; margin: 20px 0;">';
        echo '<img src="' . esc_url($image_url) . '" style="max-width: 100%; max-height: 600px; height: auto; border: 1px solid #ddd; padding: 5px;" />';
        echo '<div style="margin-top: 15px;">';
        echo '<a href="' . esc_url($large_image_url) . '" target="_blank" class="button button-primary button-large">View Full Size Image</a>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div style="padding: 20px; background-color: #f8d7da; border-left: 4px solid #d63638; color: #721c24;">';
        echo '<p><strong>No payment proof image found for this submission.</strong></p>';
        echo '</div>';
    }
}
add_action('add_meta_boxes', 'stallion_payment_proof_meta_boxes');

// Display payment proof details meta box
function stallion_payment_proof_details_meta_box($post) {
    $user_id = get_post_meta($post->ID, 'user_id', true);
    $user_info = get_userdata($user_id);
    $user_email = get_post_meta($post->ID, 'user_email', true);
    $plan_type = get_post_meta($post->ID, 'plan_type', true);
    $payment_status = get_post_meta($post->ID, 'payment_status', true) ?: 'pending';
    
    echo '<p><strong>Username:</strong> ' . esc_html($user_info->user_login) . '</p>';
    echo '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($user_email) . '">' . esc_html($user_email) . '</a></p>';
    echo '<p><strong>Plan:</strong> ' . ucfirst(esc_html($plan_type)) . '</p>';
    echo '<p><strong>Status:</strong> ' . ucfirst(esc_html($payment_status)) . '</p>';
}

// Display payment proof actions meta box
function stallion_payment_proof_actions_meta_box($post) {
    wp_nonce_field('payment_action_nonce', 'payment_action_nonce');
    $payment_status = get_post_meta($post->ID, 'payment_status', true) ?: 'pending';
    
    echo '<div class="payment-actions">';
    
    if ($payment_status !== 'approved') {
        echo '<button type="button" class="button button-primary button-large" id="approve-payment" style="margin-right: 5px; width: 100%; margin-bottom: 10px;">Approve Payment</button>';
    }
    
    if ($payment_status !== 'rejected') {
        echo '<button type="button" class="button button-large" id="reject-payment" style="width: 100%;">Reject Payment</button>';
    }
    
    echo '<input type="hidden" name="payment_action" id="payment_action" value="">';
    echo '</div>';
    
    // Add JavaScript for button actions
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#approve-payment').on('click', function() {
                $('#payment_action').val('approve');
                $('#publish').click();
            });
            
            $('#reject-payment').on('click', function() {
                $('#payment_action').val('reject');
                $('#publish').click();
            });
        });
    </script>
    <?php
}

// Process payment actions
function stallion_save_payment_proof_meta($post_id, $post) {
    // Skip autosave, revisions, etc.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($post->post_type !== 'payment_proof') return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!isset($_POST['payment_action_nonce']) || !wp_verify_nonce($_POST['payment_action_nonce'], 'payment_action_nonce')) return;
    
    // Process payment action
    if (isset($_POST['payment_action'])) {
        $action = $_POST['payment_action'];
        
        if ($action === 'approve' || $action === 'reject') {
            $payment_status = $action === 'approve' ? 'approved' : 'rejected';
            update_post_meta($post_id, 'payment_status', $payment_status);
            
            // Get user information
            $user_id = get_post_meta($post_id, 'user_id', true);
            $user_info = get_userdata($user_id);
            $user_email = $user_info->user_email;
            $plan_type = get_post_meta($post_id, 'plan_type', true);
            
            // If approved, update user subscription status
            if ($action === 'approve') {
                // Set subscription information
                $subscription_duration = '1 month';
                switch ($plan_type) {
                    case 'basic':
                        $subscription_plan = 'basic';
                        break;
                    case 'pro':
                        $subscription_plan = 'pro';
                        break;
                    case 'premium':
                        $subscription_plan = 'premium';
                        break;
                    default:
                        $subscription_plan = 'basic';
                }
                
                // Calculate expiry date
                $expiry_date = date('Y-m-d H:i:s', strtotime('+' . $subscription_duration));
                
                // Update user meta
                update_user_meta($user_id, 'subscription_status', 'active');
                update_user_meta($user_id, 'subscription_plan', $subscription_plan);
                update_user_meta($user_id, 'subscription_expiry', $expiry_date);
                
                // Send approval email
                $subject = 'Your Payment has been Approved';
                $message = "Hello {$user_info->user_login},\n\n";
                $message .= "Your payment for the " . ucfirst($plan_type) . " plan has been approved!\n\n";
                $message .= "Your subscription is now active and will expire on " . date('F j, Y', strtotime($expiry_date)) . ".\n\n";
                $message .= "You now have full access to all the features included in your subscription plan.\n\n";
                $message .= "Thank you for your business!\n\n";
                $message .= "Best regards,\n";
                $message .= get_bloginfo('name') . " Team";
            } else {
                // Send rejection email
                $subject = 'Your Payment has been Rejected';
                $message = "Hello {$user_info->user_login},\n\n";
                $message .= "We regret to inform you that your payment for the " . ucfirst($plan_type) . " plan has been rejected.\n\n";
                $message .= "This could be due to one of the following reasons:\n";
                $message .= "- The payment proof was unclear or unreadable\n";
                $message .= "- The payment amount didn't match the plan price\n";
                $message .= "- The payment was not received in our account\n\n";
                $message .= "Please contact our support team for more information or submit a new payment proof.\n\n";
                $message .= "Best regards,\n";
                $message .= get_bloginfo('name') . " Team";
            }
            
            // Send email notification
            wp_mail($user_email, $subject, $message);
        }
    }
}
add_action('save_post', 'stallion_save_payment_proof_meta', 10, 2);

// Add custom columns to payment_proof list
function stallion_payment_proof_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['user'] = 'User';
    $new_columns['plan'] = 'Plan';
    $new_columns['status'] = 'Status';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_payment_proof_posts_columns', 'stallion_payment_proof_columns');

// Add content to custom columns
function stallion_payment_proof_column_content($column_name, $post_id) {
    if ($column_name === 'user') {
        $user_id = get_post_meta($post_id, 'user_id', true);
        $user_info = get_userdata($user_id);
        if ($user_info) {
            echo esc_html($user_info->user_login) . '<br>';
            echo '<small>' . esc_html($user_info->user_email) . '</small>';
        }
    }
    
    if ($column_name === 'plan') {
        $plan = get_post_meta($post_id, 'plan_type', true);
        echo ucfirst(esc_html($plan));
    }
    
    if ($column_name === 'status') {
        $status = get_post_meta($post_id, 'payment_status', true) ?: 'pending';
        
        $status_colors = array(
            'pending' => '#f0b849',
            'approved' => '#5cb85c',
            'rejected' => '#d9534f'
        );
        
        echo '<span style="display:inline-block; padding:3px 6px; border-radius:3px; background-color:' . $status_colors[$status] . '; color:#fff;">';
        echo ucfirst(esc_html($status));
        echo '</span>';
    }
}
add_action('manage_payment_proof_posts_custom_column', 'stallion_payment_proof_column_content', 10, 2);

// Add status filter to payment proof list
function stallion_payment_proof_filter_dropdown() {
    global $typenow;
    if ($typenow === 'payment_proof') {
        $current_status = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';
        ?>
        <select name="payment_status">
            <option value="">All Statuses</option>
            <option value="pending" <?php selected($current_status, 'pending'); ?>>Pending</option>
            <option value="approved" <?php selected($current_status, 'approved'); ?>>Approved</option>
            <option value="rejected" <?php selected($current_status, 'rejected'); ?>>Rejected</option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', 'stallion_payment_proof_filter_dropdown');

// Filter payment proofs by status
function stallion_payment_proof_filter_query($query) {
    global $pagenow, $typenow;
    
    if (is_admin() && $pagenow === 'edit.php' && $typenow === 'payment_proof' && isset($_GET['payment_status']) && $_GET['payment_status'] !== '') {
        $query->query_vars['meta_key'] = 'payment_status';
        $query->query_vars['meta_value'] = $_GET['payment_status'];
    }
}
add_action('pre_get_posts', 'stallion_payment_proof_filter_query');

// Auto-verify admin accounts
function stallion_auto_verify_admin_accounts() {
    // Only run this in admin area or during login
    if (!is_admin() && !wp_doing_ajax() && !defined('DOING_CRON')) {
        return;
    }
    
    // Get admin users
    $admin_users = get_users(array(
        'role__in' => array('administrator', 'editor'),
        'fields' => array('ID', 'user_login', 'user_email'),
    ));
    
    foreach ($admin_users as $admin) {
        $verified = get_user_meta($admin->ID, 'email_verified', true);
        
        if ($verified !== '1') {
            // Auto-verify this admin user
            update_user_meta($admin->ID, 'email_verified', '1');
            update_user_meta($admin->ID, 'account_status', 'active');
            delete_user_meta($admin->ID, 'account_activation_key');
            
            // Log this action
            error_log("Admin user {$admin->user_login} (ID: {$admin->ID}) was automatically verified by the system.");
        }
    }
}
add_action('admin_init', 'stallion_auto_verify_admin_accounts');

// Display admin notice about verification bypass
function stallion_admin_verification_notice() {
    // Only show to administrators
    if (!current_user_can('manage_options')) {
        return;
    }
    
    echo '<div class="notice notice-info is-dismissible">';
    echo '<p><strong>Email Verification Bypass:</strong> Administrator and Editor accounts automatically bypass email verification. ';
    echo 'This helps prevent lockouts due to email delivery issues.</p>';
    echo '</div>';
}
add_action('admin_notices', 'stallion_admin_verification_notice');

// --- Affiliate Applications CPT Registration ---
function my_register_affiliate_applications_cpt() {
    $labels = array(
        'name' => 'Affiliate Applications',
        'singular_name' => 'Affiliate Application',
        'menu_name' => 'Affiliate Applications',
        'name_admin_bar' => 'Affiliate Application',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Application',
        'edit_item' => 'Edit Application',
        'new_item' => 'New Application',
        'view_item' => 'View Application',
        'search_items' => 'Search Applications',
        'not_found' => 'No applications found',
        'not_found_in_trash' => 'No applications found in Trash',
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title'),
        'capability_type' => 'post',
        'show_in_admin_bar' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
    );
    register_post_type('affiliate_application', $args);
}
add_action('init', 'my_register_affiliate_applications_cpt');

// Add meta box for Affiliate Application details
function my_add_affiliate_application_meta_box() {
    add_meta_box(
        'affiliate_application_details',
        'Affiliate Application Details',
        function($post) {
            $email = get_post_meta($post->ID, 'affiliate_email', true);
            $name = get_post_meta($post->ID, 'affiliate_name', true);
            $message = get_post_meta($post->ID, 'affiliate_message', true);
            echo '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
            echo '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
            echo '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>';
        },
        'affiliate_application',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'my_add_affiliate_application_meta_box');

// Debug: Show admin notice to confirm CPT code is running
add_action('admin_notices', function() {
    if (post_type_exists('affiliate_application')) {
        echo '<div class="notice notice-success"><p>Affiliate Application CPT is registered.</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>Affiliate Application CPT is NOT registered.</p></div>';
    }
});

/**
 * Show payment proof images in the admin area
 */
function stallion_protect_payment_proof_images() {
    global $post;
    
    // Only run on payment_proof post type edit screen
    if (!$post || get_post_type($post->ID) !== 'payment_proof') return;
    
    // Get the featured image ID and display it directly
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $payment_proof_id = get_post_meta($post->ID, 'payment_proof_image', true);
    
    echo '<style>
        /* Force image display for better visibility */
        .post-type-payment_proof .postbox img {
            display: block !important;
            max-width: 100%;
            height: auto;
            max-height: 600px;
        }
        /* Add a notice at the top of the page */
        .payment-image-notice {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f0f0f1;
            border-left: 4px solid #2271b1;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        /* Improve image display */
        .payment-proof-container {
            margin: 20px 0;
            background-color: #fff;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }
        .payment-proof-image {
            width: 100%;
            text-align: center;
        }
    </style>';
    
    echo '<div class="payment-image-notice">';
    echo '<p><strong>Payment Proof Image:</strong> The image below is the payment proof submitted by the user. You can view it at full size by clicking the link below.</p>';
    echo '</div>';
    
    if ($thumbnail_id || $payment_proof_id) {
        $image_id = $thumbnail_id ? $thumbnail_id : $payment_proof_id;
        $image_url = wp_get_attachment_url($image_id);
        $large_image_url = wp_get_attachment_image_src($image_id, 'large');
        if ($large_image_url) {
            $large_image_url = $large_image_url[0];
        } else {
            $large_image_url = $image_url;
        }
        
        echo '<div class="payment-proof-container">';
        echo '<div class="payment-proof-image">';
        echo '<img src="' . esc_url($image_url) . '" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;" />';
        echo '</div>';
        echo '<div style="margin-top: 10px; text-align: center;">';
        echo '<a href="' . esc_url($large_image_url) . '" target="_blank" class="button button-primary">View Full Size Image</a>';
        echo '</div>';
        echo '</div>';    } else {
        echo '<div style="margin: 20px 0; padding: 15px; background-color: #f8d7da; border-left: 4px solid #d63638;">';
        echo '<p>No payment proof image found for this submission.</p>';
        echo '</div>';
    }
    
    // Add JavaScript to disable media selection
    echo '<script type="text/javascript">
        jQuery(document).ready(function($) {
            // Disable the thumbnail functionality
            $("#set-post-thumbnail").off("click").on("click", function(e) {
                e.preventDefault();
                alert("Modifying payment proof images is not allowed for security and integrity purposes.");
            });
            
            // Disable drag & drop for featured image
            $("#postimagediv").on("dragover dragenter drop", function(e) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            });
            
            // Show a notice at the top of the edit screen
            $(".wrap h1").after(\'<div class="notice notice-warning"><p><strong>Payment Proof Protection:</strong> The payment proof image cannot be modified or replaced for security and integrity purposes. This ensures the validity of payment records.</p></div>\');
        });
    </script>';
}
add_action('admin_head-post.php', 'stallion_protect_payment_proof_images');

/**
 * Prevent programmatic changes to payment proof featured images
 */
function stallion_prevent_payment_proof_image_update($meta_id, $post_id, $meta_key, $meta_value) {
    // Check if this is a thumbnail/featured image update on a payment proof
    if ($meta_key === '_thumbnail_id' && get_post_type($post_id) === 'payment_proof') {
        // Get the current thumbnail ID
        $current_thumbnail_id = get_post_thumbnail_id($post_id);
        
        // If there's already an image set and someone is trying to change it, prevent the change
        if ($current_thumbnail_id && $current_thumbnail_id != $meta_value) {
            // Block the update by restoring the original value
            update_post_meta($post_id, '_thumbnail_id', $current_thumbnail_id);
            
            // Log the attempt
            error_log('Attempt to modify payment proof image prevented. Post ID: ' . $post_id);
        }
    }
}
add_action('updated_post_meta', 'stallion_prevent_payment_proof_image_update', 10, 4);
add_action('added_post_meta', 'stallion_prevent_payment_proof_image_update', 10, 4);

/**
 * Disable media replacement for payment proof attachments
 */
function stallion_check_payment_proof_image($attachment_id) {
    // Check if this attachment is used as payment proof
    global $wpdb;
    $used_as_payment_proof = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT post_id FROM $wpdb->postmeta 
            WHERE meta_key = 'payment_proof_image' 
            AND meta_value = %d",
            $attachment_id
        )
    );
    
    // If attachment is used in a payment proof, prevent replacement
    if ($used_as_payment_proof) {
        wp_die('This image cannot be replaced because it is used as payment proof evidence. This restriction is in place to maintain the integrity of payment records.');
        exit;
    }
    
    // Check if it's a featured image for a payment proof post
    $featured_in_payment_proof = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT p.ID FROM $wpdb->posts p
            JOIN $wpdb->postmeta pm ON p.ID = pm.post_id
            WHERE p.post_type = 'payment_proof'
            AND pm.meta_key = '_thumbnail_id'
            AND pm.meta_value = %d",
            $attachment_id
        )
    );
    
    if ($featured_in_payment_proof) {
        wp_die('This image cannot be replaced because it is used as payment proof evidence. This restriction is in place to maintain the integrity of payment records.');
        exit;
    }
    
    return true;
}
add_filter('pre_delete_attachment', 'stallion_check_payment_proof_image', 10, 1);

/**
 * Protect payment proof attachments in the media library
 */
function stallion_protect_payment_proof_attachments_js() {
    // Only run on media pages
    $screen = get_current_screen();
    if (!$screen || !in_array($screen->base, array('upload', 'media', 'media-upload'))) {
        return;
    }
    
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Function to check if an attachment is used in payment proof
        function isPaymentProofImage(attachmentId) {
            // This is a simplified check - for the real implementation we'd need AJAX
            // For now, we'll just add a class to payment proof images from PHP side
            return $('#post-' + attachmentId).hasClass('payment-proof-image');
        }
        
        // Disable delete for payment proof images
        $(document).on('click', '.delete-attachment', function(e) {
            var attachmentId = $(this).closest('tr, .attachment').data('id');
            if ($(this).closest('tr, .attachment').hasClass('payment-proof-image')) {
                e.preventDefault();
                alert('Payment proof images cannot be deleted or modified for security and integrity reasons.');
                return false;
            }
        });
        
        // Disable edit for payment proof images
        $(document).on('click', '.edit-attachment', function(e) {
            if ($(this).closest('tr, .attachment').hasClass('payment-proof-image')) {
                e.preventDefault();
                alert('Payment proof images cannot be edited for security and integrity reasons. You can still view the image.');
                return false;
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'stallion_protect_payment_proof_attachments_js');

/**
 * Add identifier class to payment proof images in media library
 */
function stallion_mark_payment_proof_images_in_media_library($actions, $post) {
    // Check if this attachment is used as payment proof
    global $wpdb;
    $used_as_payment_proof = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT post_id FROM $wpdb->postmeta 
            WHERE meta_key = 'payment_proof_image' 
            AND meta_value = %d",
            $post->ID
        )
    );
    
    // Check if it's a featured image for a payment proof post
    if (!$used_as_payment_proof) {
        $featured_in_payment_proof = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT p.ID FROM $wpdb->posts p
                JOIN $wpdb->postmeta pm ON p.ID = pm.post_id
                WHERE p.post_type = 'payment_proof'
                AND pm.meta_key = '_thumbnail_id'
                AND pm.meta_value = %d",
                $post->ID
            )
        );
    }
    
    // If attachment is used in a payment proof, add a class and note
    if ($used_as_payment_proof || $featured_in_payment_proof) {
        add_action('admin_footer', function() use ($post) {
            echo '<script type="text/javascript">
                jQuery(document).ready(function($) {
                    $("#post-' . $post->ID . '").addClass("payment-proof-image");
                    // Add a visual indicator
                    $("#post-' . $post->ID . ' .column-title").append("<span style=\"display:block;color:#d63638;font-size:12px;margin-top:4px;\">⚠️ Payment Proof (Protected)</span>");
                });
            </script>';
        });
        
        // Modify the actions to remove edit/delete options
        unset($actions['delete']);
        unset($actions['trash']);
        $actions['edit'] = '<a href="' . get_permalink($used_as_payment_proof) . '">View Payment Record</a>';
    }
    
    return $actions;
}
add_filter('media_row_actions', 'stallion_mark_payment_proof_images_in_media_library', 10, 2);

/**
 * Remove admin bar for non-admin users
 */
function stallion_remove_admin_bar() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'stallion_remove_admin_bar');

/**
 * Redirect non-admin users away from the WordPress admin area
 */
function stallion_redirect_non_admin_users() {
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url('/profile'));
        exit;
    }
}
add_action('admin_init', 'stallion_redirect_non_admin_users');

// AJAX handler for custom password reset
add_action('wp_ajax_nopriv_custom_reset_password', 'stallion_custom_reset_password');
add_action('wp_ajax_custom_reset_password', 'stallion_custom_reset_password');
function stallion_custom_reset_password() {
    $username = isset($_POST['user_login']) ? sanitize_user($_POST['user_login']) : '';
    $email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $response = array('success' => false);
    if (!$username || !$email || !$new_password) {
        $response['message'] = 'All fields are required.';
        wp_send_json($response);
        exit;
    }
    $user = get_user_by('login', $username);
    if (!$user || $user->user_email !== $email) {
        $response['message'] = 'Username and email do not match.';
        wp_send_json($response);
        exit;
    }
    // Validate password strength
    if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
        $response['message'] = 'Password does not meet requirements.';
        wp_send_json($response);
        exit;
    }
    reset_password($user, $new_password);
    $response['success'] = true;
    $response['message'] = 'Password reset successful. You can now log in.';
    wp_send_json($response);
    exit;
}

// --- Affiliate Form Handler ---
function stallion_process_affiliate_form() {
    if (isset($_POST['affiliate_form_nonce']) && wp_verify_nonce($_POST['affiliate_form_nonce'], 'affiliate_form_nonce')) {
        $email = sanitize_email($_POST['affiliate_email']);
        $first_name = sanitize_text_field($_POST['affiliate_first_name']);
        $password = $_POST['affiliate_password'];
        $password_confirm = $_POST['affiliate_password_confirm'];
        $paypal = sanitize_email($_POST['affiliate_paypal']);
        $errors = array();
        if ($password !== $password_confirm) {
            $errors[] = 'Passwords do not match.';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        }
        if (email_exists($email)) {
            $errors[] = 'This email address is already registered.';
        }
        if (!empty($errors)) {
            // Log error in a user-friendly way
            error_log('Affiliate form error: ' . implode(' ', $errors));
            wp_redirect(add_query_arg('affiliate_error', urlencode(implode(' ', $errors)), wp_get_referer()));
            exit;
        }
        // Save as Contact CPT, marked as Affiliate
        $contact_id = wp_insert_post([
            'post_type' => 'contact_message',
            'post_title' => '[Affiliate] ' . $first_name . ' (' . $email . ')',
            'post_status' => 'publish',
        ]);
        if ($contact_id) {
            update_post_meta($contact_id, 'contact_email', $email);
            update_post_meta($contact_id, 'contact_paypal', $paypal);
            update_post_meta($contact_id, 'contact_name', $first_name);
            // Craft a user-friendly message for the contact_message content
            $crafted_message = "I would like to signup for the affiliate program.\n\nName: $first_name\nEmail: $email\nPayPal Email: $paypal";
            // Save as post_content so it appears in the main content box in admin
            wp_update_post([
                'ID' => $contact_id,
                'post_content' => $crafted_message
            ]);
            update_post_meta($contact_id, 'contact_message', $crafted_message);
            // Send crafted email to admin
            $admin_email = get_option('admin_email');
            $subject = 'New Affiliate Application';
            $body = "Affiliate Application Details:\n\nName: $first_name\nEmail: $email\nPayPal Email: $paypal";
            $headers = array('Content-Type: text/plain; charset=UTF-8');
            wp_mail($admin_email, $subject, $body, $headers);
            $redirect_url = home_url('/affiliate/');
            $redirect_url = add_query_arg('affiliate_status', 'success', $redirect_url);
            wp_send_json_success(['redirect' => $redirect_url]);
        } else {
            $error_message = is_wp_error($post_id) ? $post_id->get_error_message() : 'There was a problem saving your application. Please try again.';
            error_log('Affiliate form error: ' . $error_message);
            wp_redirect(add_query_arg('affiliate_error', urlencode($error_message), wp_get_referer() ?: home_url('/affiliate')));
            exit;
        }
    }
    wp_redirect(add_query_arg('affiliate_error', urlencode('Security check failed. Please refresh and try again.'), home_url('/affiliate')));
    exit;
}
add_action('admin_post_process_affiliate_form', 'stallion_process_affiliate_form');
add_action('admin_post_nopriv_process_affiliate_form', 'stallion_process_affiliate_form');

// Register Affiliate Applications CPT
function register_affiliate_applications_cpt() {
    $labels = array(
        'name' => 'Affiliate Applications',
        'singular_name' => 'Affiliate Application',
        'menu_name' => 'Affiliate Applications',
        'name_admin_bar' => 'Affiliate Application',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Application',
        'edit_item' => 'Edit Application',
        'new_item' => 'New Application',
        'view_item' => 'View Application',
        'search_items' => 'Search Applications',
        'not_found' => 'No applications found',
        'not_found_in_trash' => 'No applications found in Trash',
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title'),
        'capability_type' => 'post',
        'show_in_admin_bar' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
    );
    register_post_type('affiliate_application', $args);
}
add_action('init', 'register_affiliate_applications_cpt');

// Add meta box for Affiliate Application details
function add_affiliate_application_meta_box() {
    add_meta_box(
        'affiliate_application_details',
        'Affiliate Application Details',
        function($post) {
            $email = get_post_meta($post->ID, 'affiliate_email', true);
            $name = get_post_meta($post->ID, 'affiliate_name', true);
            $message = get_post_meta($post->ID, 'affiliate_message', true);
            echo '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
            echo '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
            echo '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>';
        },
        'affiliate_application',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_affiliate_application_meta_box');

// Handle Affiliate Form Submission (AJAX)
function handle_affiliate_form() {
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $paypal = isset($_POST['paypal']) ? sanitize_email($_POST['paypal']) : '';
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    if (!$email || !$name || !$paypal) {
        wp_send_json_error(['message' => 'All fields are required.']);
    }
    // Check for duplicate affiliate signup by email (must not already exist with [Affiliate] in title)
    $existing = get_posts([
        'post_type' => 'contact_message',
        'meta_query' => [
            [
                'key' => 'contact_email',
                'value' => $email,
                'compare' => '=',
            ]
        ],
        's' => '[Affiliate]',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ]);
    if ($existing) {
        wp_send_json_error(['message' => 'This email has already applied as an affiliate.']);
    }
    // Craft the message
    $crafted_message = "I would like to signup for the affiliate program.\n\nName: $name\nEmail: $email\nPayPal Email: $paypal";
    // Save as Contact CPT, marked as Affiliate
    $contact_id = wp_insert_post([
        'post_type' => 'contact_message',
        'post_title' => '[Affiliate] ' . $name . ' (' . $email . ')',
        'post_status' => 'publish',
        'post_content' => $crafted_message,
    ]);
    if ($contact_id) {
        update_post_meta($contact_id, 'contact_email', $email);
        update_post_meta($contact_id, 'contact_paypal', $paypal);
        update_post_meta($contact_id, 'contact_name', $name);
        update_post_meta($contact_id, 'contact_message', $crafted_message);
        // Send crafted email to admin
        $admin_email = get_option('admin_email');
        $subject = 'New Affiliate Application';
        $body = "Affiliate Application Details:\n\nName: $name\nEmail: $email\nPayPal Email: $paypal";
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        wp_mail($admin_email, $subject, $body, $headers);
        wp_send_json_success(['message' => 'Affiliate application submitted successfully!']);
    } else {
        wp_send_json_error(['message' => 'There was a problem saving your application. Please try again.']);
    }
}
add_action('wp_ajax_affiliate_form', 'handle_affiliate_form');
add_action('wp_ajax_nopriv_affiliate_form', 'handle_affiliate_form');

// Fallback for non-AJAX (if form posts to page)
function handle_affiliate_form_fallback() {
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $paypal = isset($_POST['paypal']) ? sanitize_email($_POST['paypal']) : '';
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    if (!$email || !$name || !$message || !$paypal) {
        return ['success' => false, 'message' => 'All fields are required.'];
    }
    $existing = get_posts([
        'post_type' => 'contact_message',
        'meta_query' => [
            [
                'key' => 'contact_email',
                'value' => $email,
                'compare' => '=',
            ]
        ],
        's' => '[Affiliate]',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ]);
    if ($existing) {
        return ['success' => false, 'message' => 'This email has already applied as an affiliate.'];
    }
    $contact_id = wp_insert_post([
        'post_type' => 'contact_message',
        'post_title' => '[Affiliate] ' . $name . ' (' . $email . ')',
        'post_status' => 'publish',
    ]);
    if ($contact_id) {
        update_post_meta($contact_id, 'contact_email', $email);
        update_post_meta($contact_id, 'contact_paypal', $paypal);
        update_post_meta($contact_id, 'contact_name', $name);
        update_post_meta($contact_id, 'contact_message', '[Affiliate] ' . $message);
        return ['success' => true, 'message' => 'Affiliate application submitted successfully!'];
    } else {
        return ['success' => false, 'message' => 'There was a problem saving your application. Please try again.'];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['affiliate_form'])) {
    $result = handle_affiliate_form_fallback();
    $redirect_url = home_url('/affiliate/');
    if ($result['success']) {
        $redirect_url = add_query_arg('affiliate_status', 'success', $redirect_url);
    } else {
        $redirect_url = add_query_arg('affiliate_status', 'error', $redirect_url);
        $redirect_url = add_query_arg('affiliate_message', urlencode($result['message']), $redirect_url);
    }
    wp_redirect($redirect_url);
    exit;
}

// Rename Contacts tab to Contact/Affiliate Queries
add_filter('register_post_type_args', function($args, $post_type) {
    if ($post_type === 'contact_message') {
        $args['labels']['menu_name'] = 'Contact/Affiliate Queries';
        $args['menu_name'] = 'Contact/Affiliate Queries';
    }
    return $args;
}, 10, 2);

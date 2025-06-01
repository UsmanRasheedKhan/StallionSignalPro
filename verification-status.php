<?php
/**
 * Email Verification Status Checker
 * This file contains functions to check and manage email verification status
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if email verification functionality is working properly
 * Returns true if working, false if system should bypass verification
 * Currently hardcoded to return false to force manual verification
 */
function stallion_check_verification_status() {
    // Force manual verification by always returning false
    return false;
    
    // Original code below is now bypassed
    $verification_enabled = get_option('stallion_email_verification_enabled', true);
    $failed_count = (int) get_option('stallion_email_failed_count', 0);
    
    // If verification has been disabled due to consistent failures, check if we should retry
    if (!$verification_enabled) {
        // Check if it's been more than 24 hours since last check
        $last_check = get_option('stallion_email_last_check', 0);
        $current_time = time();
        
        if (($current_time - $last_check) > 86400) { // 86400 = 24 hours
            // It's been more than 24 hours, let's try email verification again
            update_option('stallion_email_verification_enabled', true);
            update_option('stallion_email_failed_count', 0);
            update_option('stallion_email_last_check', $current_time);
            return true;
        }
        
        return false;
    }
    
    return true;
}

/**
 * Record a failed email verification attempt
 * If too many failures occur, temporarily disable verification
 */
function stallion_record_verification_failure() {
    $failed_count = (int) get_option('stallion_email_failed_count', 0);
    $failed_count++;
    update_option('stallion_email_failed_count', $failed_count);
    
    // If we've had 5 consecutive failures, disable verification temporarily
    if ($failed_count >= 5) {
        update_option('stallion_email_verification_enabled', false);
        update_option('stallion_email_last_check', time());
        
        // Log this event
        error_log("Email verification disabled due to $failed_count consecutive failures.");
    }
}

/**
 * Record a successful email verification
 * Reset the failure counter
 */
function stallion_record_verification_success() {
    // Reset the counter
    update_option('stallion_email_failed_count', 0);
    update_option('stallion_email_verification_enabled', true);
    
    // Log this event
    error_log("Email verification successful, reset failure counter.");
}

/**
 * Check if user should be auto-verified due to system issues
 */
function stallion_should_auto_verify($user_id) {
    return !stallion_check_verification_status();
}

/**
 * Display admin notice about email verification status
 */
function stallion_email_verification_notice() {
    // Only show to admin users
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Check if verification is disabled
    if (!stallion_check_verification_status()) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Email Verification System:</strong> Automatic email verification is currently disabled due to persistent delivery issues. New user accounts will need to verify manually.</p>
            <p>The system will automatically retry in 24 hours, or you can <a href="<?php echo esc_url(admin_url('options-general.php?page=email-settings&reset_verification=1')); ?>">reset it manually</a>.</p>
        </div>
        <?php
    }
    
    $failed_count = (int) get_option('stallion_email_failed_count', 0);
    if ($failed_count > 0) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Email System Warning:</strong> There have been <?php echo $failed_count; ?> consecutive email delivery failures. If this reaches 5, email verification will be temporarily disabled.</p>
        </div>        <?php
    }
}
add_action('admin_notices', 'stallion_email_verification_notice');

<?php
/**
 * Email Domain Validation
 * This file contains functionality for validating email domains
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if an email domain is valid
 * Only allows emails from Gmail, Outlook, and Yahoo
 */
function stallion_is_valid_email_domain($email) {
    // Get the domain part
    $domain = substr(strrchr($email, "@"), 1);
    
    if (empty($domain)) {
        return false;
    }
    
    // List of allowed email domains
    $allowed_domains = array(
        // Gmail domains
        'gmail.com',
        'googlemail.com',
        
        // Outlook/Microsoft domains
        'outlook.com',
        'hotmail.com',
        'live.com',
        'msn.com',
        'outlook.co.uk',
        'outlook.fr',
        'outlook.de',
        'outlook.jp',
        'outlook.com.au',
        'hotmail.co.uk',
        'hotmail.fr',
        
        // Yahoo domains
        'yahoo.com',
        'yahoo.co.uk',
        'yahoo.fr',
        'yahoo.de',
        'yahoo.com.au',
        'ymail.com',
        'rocketmail.com'
    );
      // Check if the domain is in the allowed list
    return in_array(strtolower($domain), $allowed_domains);
}

/**
 * Get a formatted error message for invalid email domains
 */
function stallion_get_invalid_email_message() {
    return 'Please use a valid email address from Gmail, Outlook, or Yahoo mail services only.';
}

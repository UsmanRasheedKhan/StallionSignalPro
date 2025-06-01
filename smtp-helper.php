<?php
/**
 * SMTP Helper Functions
 * This file contains helper functions for SMTP email configuration
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configure WordPress to use Gmail SMTP for all emails
 */
function stallion_gmail_smtp_init() {
    add_action('phpmailer_init', 'stallion_gmail_smtp_configure');
}
add_action('init', 'stallion_gmail_smtp_init');

/**
 * Configure PHPMailer to use Gmail SMTP
 */
function stallion_gmail_smtp_configure($phpmailer) {
    // Try to use phpmailer for a stable connection
    try {
        // Gmail SMTP configuration
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'murkssayings@gmail.com';
        
        // App password - ensure all spaces are removed
        $phpmailer->Password = 'cvfvhrfwfzlvcfnr';
        
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->From = 'murkssayings@gmail.com';
        $phpmailer->FromName = get_bloginfo('name');
        
        // SMTP options for better security and compatibility
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // Debug settings - lower debug level in production
        $phpmailer->SMTPDebug = 1; // Output debug info
        $phpmailer->Debugoutput = function($str, $level) {
            error_log("SMTP Debug: $str");
            
            // Also write to a custom debug file
            $debug_file = get_template_directory() . '/smtp-debug.log';
            file_put_contents($debug_file, date('Y-m-d H:i:s') . " [$level] $str\n", FILE_APPEND);
        };
        
        // Force STARTTLS encryption
        $phpmailer->SMTPAutoTLS = true;
        
        // Set timeout higher for slower connections
        $phpmailer->Timeout = 60; // 60 seconds timeout
        
        // Set sender name and email clearly
        $phpmailer->clearAllRecipients();
        $phpmailer->clearReplyTos();
        $phpmailer->addReplyTo('murkssayings@gmail.com', get_bloginfo('name'));
        
        // Enable keep-alive for better performance with multiple recipients
        $phpmailer->SMTPKeepAlive = true;
    } catch (Exception $e) {
        // Log any exceptions that occur during setup
        error_log('PHPMailer setup exception: ' . $e->getMessage());
        // Write to detailed log
        $debug_file = get_template_directory() . '/smtp-exceptions.log';
        file_put_contents($debug_file, date('Y-m-d H:i:s') . " - Exception: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}

/**
 * Create a wrapper function for wp_mail to provide additional debugging
 */
function stallion_enhanced_mail($to, $subject, $message, $headers = '', $attachments = array()) {
    // Log the attempt
    $log_file = get_template_directory() . '/mail-attempts.log';
    $log_entry = date('Y-m-d H:i:s') . " - Sending email to: $to, Subject: $subject\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
    
    // Try to send the email
    $result = wp_mail($to, $subject, $message, $headers, $attachments);
    
    // Log the result
    $result_entry = date('Y-m-d H:i:s') . " - Result: " . ($result ? "Success" : "Failed") . "\n";
    file_put_contents($log_file, $result_entry, FILE_APPEND);
    
    return $result;
}

/**
 * Admin page to test email delivery
 */
function stallion_add_email_test_page() {
    add_menu_page(
        'Email Test',
        'Email Test',
        'manage_options',
        'email-test',
        'stallion_email_test_page_content',
        'dashicons-email',
        99
    );
}
add_action('admin_menu', 'stallion_add_email_test_page');

/**
 * Content for the email test page
 */
function stallion_email_test_page_content() {
    $message = '';
    $status = '';
    
    // Process test email request
    if (isset($_POST['send_test_email']) && isset($_POST['recipient'])) {
        $recipient = sanitize_email($_POST['recipient']);
        
        if (!empty($recipient)) {
            $subject = 'SMTP Test Email - ' . date('Y-m-d H:i:s');
            $content = "This is a test email sent from your WordPress site.\n\n";
            $content .= "Site: " . get_bloginfo('name') . "\n";
            $content .= "URL: " . get_site_url() . "\n";
            $content .= "Date: " . date('Y-m-d H:i:s') . "\n";
            
            $result = stallion_enhanced_mail($recipient, $subject, $content);
            
            if ($result) {
                $status = 'success';
                $message = "Test email sent successfully to $recipient. Please check your inbox (and spam folder).";
            } else {
                $status = 'error';
                $message = "Failed to send test email. Check your SMTP settings and server logs.";
            }
        }
    }
    
    // Display the test form
    ?>
    <div class="wrap">
        <h1>Email Delivery Test</h1>
        
        <?php if ($message): ?>
        <div class="notice notice-<?php echo $status; ?> is-dismissible">
            <p><?php echo esc_html($message); ?></p>
        </div>
        <?php endif; ?>
        
        <p>Use this form to test if your WordPress site can send emails properly:</p>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="recipient">Send test email to:</label></th>
                    <td>
                        <input type="email" name="recipient" id="recipient" class="regular-text" 
                               value="<?php echo esc_attr(get_option('admin_email')); ?>" required>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" name="send_test_email" class="button button-primary" value="Send Test Email">
            </p>
        </form>
        
        <h2>Current SMTP Settings</h2>
        <table class="widefat">
            <tr>
                <th>SMTP Host</th>
                <td>smtp.gmail.com</td>
            </tr>
            <tr>
                <th>SMTP Port</th>
                <td>587</td>
            </tr>
            <tr>
                <th>Encryption</th>
                <td>TLS</td>
            </tr>
            <tr>
                <th>Authentication</th>
                <td>Yes (Username/Password)</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>murkssayings@gmail.com</td>
            </tr>
        </table>
        
        <h2>Email Delivery Troubleshooting</h2>
        <ol>
            <li>Make sure your Gmail account has "Less secure app access" enabled or you're using an app password.</li>
            <li>Check that your app password is entered correctly (no spaces).</li>
            <li>Confirm that your Gmail account doesn't have additional security restrictions.</li>
            <li>Verify that your server allows outgoing connections to port 587.</li>
            <li>Check if your hosting provider blocks outbound email.</li>
            <li>Look at the error logs for detailed information about any failures.</li>
        </ol>
    </div>
    <?php
}

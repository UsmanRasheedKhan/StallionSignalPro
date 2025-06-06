<?php
// Fallback contact form handler for Godaddy/host issues
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message'])) {
    require_once('../../../wp-load.php');
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $post_data = array(
        'post_title'    => 'Contact from ' . $name . ' - ' . $subject,
        'post_content'  => $message,
        'post_status'   => 'private',
        'post_type'     => 'contact_message',
        'post_author'   => 1,
        'meta_input'    => array(
            'contact_name' => $name,
            'contact_email' => $email,
            'contact_subject' => $subject,
        ),
    );
    $post_id = wp_insert_post($post_data);
    if ($post_id) {
        wp_redirect(home_url('/?contact=success'));
        exit;
    } else {
        wp_redirect(home_url('/?contact=error'));
        exit;
    }
} else {
    wp_redirect(home_url('/?contact=error'));
    exit;
}

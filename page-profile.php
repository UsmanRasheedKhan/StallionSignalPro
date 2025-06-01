<?php
/*
Template Name: Profile Page
*/

// Redirect non-logged in users to the homepage
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$username = $current_user->user_login;
$email = $current_user->user_email;
$subscription_status = get_user_meta($user_id, 'subscription_status', true) ?: 'inactive';
$subscription_plan = get_user_meta($user_id, 'subscription_plan', true) ?: 'none';
$subscription_expiry = get_user_meta($user_id, 'subscription_expiry', true);

// Process payment proof upload
if (isset($_POST['submit_payment_proof'])) {
    if (!empty($_FILES['payment_proof']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('payment_proof', 0);
        
        if (is_wp_error($attachment_id)) {
            $upload_error = $attachment_id->get_error_message();
        } else {
            $message_text = sanitize_textarea_field($_POST['payment_message']);
            $plan_type = sanitize_text_field($_POST['plan_type']);
            
            // Create a payment submission post
            $payment_post = array(
                'post_title'    => 'Payment from ' . $username . ' - ' . $plan_type,
                'post_content'  => $message_text,
                'post_status'   => 'private',
                'post_type'     => 'payment_proof',
                'post_author'   => $user_id,
                'meta_input'    => array(
                    'user_id' => $user_id,
                    'user_email' => $email,
                    'plan_type' => $plan_type,
                    'payment_proof_image' => $attachment_id,
                    'payment_status' => 'pending'
                )
            );
            
            $post_id = wp_insert_post($payment_post);
            
            if ($post_id) {
                // Set the attachment as the featured image
                set_post_thumbnail($post_id, $attachment_id);
                
                // Send notification to admin
                $admin_email = get_option('admin_email');
                $subject = 'New Payment Proof Submission';
                $message = "A new payment proof has been submitted.\n\n";
                $message .= "User: $username ($email)\n";
                $message .= "Plan: $plan_type\n";
                $message .= "Message: $message_text\n\n";
                $message .= "Please review this submission in your WordPress admin area.";
                
                wp_mail($admin_email, $subject, $message);
                
                $upload_success = true;
            } else {
                $upload_error = 'Failed to process your submission. Please try again.';
            }
        }
    } else {
        $upload_error = 'Please select a payment proof image to upload.';
    }
}

// Get user payment submissions
$payment_submissions = get_posts(array(
    'post_type' => 'payment_proof',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'user_id',
            'value' => $user_id,
            'compare' => '='
        )
    )
));

get_header(); ?>

<div class="pt-20 pb-12 md:pt-28 md:pb-16 px-4 sm:px-6 lg:px-8 bg-gray-900">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold mb-8">My Profile</h1>
        
        <?php if (isset($upload_success)) : ?>
        <div class="mb-8 p-4 bg-green-800 text-white rounded-md">
            Your payment proof has been submitted successfully! We will review it shortly.
        </div>
        <?php endif; ?>
        
        <?php if (isset($upload_error)) : ?>
        <div class="mb-8 p-4 bg-red-800 text-white rounded-md">
            <?php echo esc_html($upload_error); ?>
        </div>
        <?php endif; ?>

        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg mb-8">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Username</p>
                        <p class="text-lg"><?php echo esc_html($username); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-lg"><?php echo esc_html($email); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Subscription Status</p>
                        <p class="inline-block px-2 py-1 rounded <?php echo $subscription_status === 'active' ? 'bg-green-800 text-green-200' : 'bg-red-800 text-red-200'; ?>">
                            <?php echo ucfirst(esc_html($subscription_status)); ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Current Plan</p>
                        <p class="text-lg"><?php echo $subscription_plan === 'none' ? 'No Plan' : ucfirst(esc_html($subscription_plan)); ?></p>
                    </div>
                    <?php if ($subscription_expiry) : ?>
                    <div>
                        <p class="text-sm text-gray-400">Expiry Date</p>
                        <p class="text-lg"><?php echo date('F j, Y', strtotime($subscription_expiry)); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg mb-8">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold mb-4">Submit Payment Proof</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="plan_type" class="block text-sm font-medium text-gray-300 mb-1">Select Plan</label>
                        <select id="plan_type" name="plan_type" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="crypto_vip">Crypto VIP - $15/month (50% off, was $30)</option>
                            <option value="forex" data-coming-soon="1">Forex - $49/month (Coming Soon)</option>
                            <option value="gold" data-coming-soon="1">Gold - $99/month (Coming Soon)</option>
                        </select>
                        <div id="plan-error" class="hidden mt-2 text-red-400 text-sm"></div>
                    </div>
                    <div class="mb-4">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-300 mb-1">Payment Screenshot/Receipt</label>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <p class="mt-1 text-sm text-gray-400">Upload a screenshot of your payment receipt or transfer confirmation.</p>
                    </div>
                    <div class="mb-4">
                        <label for="payment_message" class="block text-sm font-medium text-gray-300 mb-1">Additional Message (Optional)</label>
                        <textarea id="payment_message" name="payment_message" rows="3" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" name="submit_payment_proof" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium transition duration-300">
                        Submit Payment Proof
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg mb-8">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold mb-4">Payment Details</h2>
                <div class="flex flex-col items-center">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/payment.jpg'); ?>" alt="Payment Details" class="rounded-lg shadow-md max-w-xs w-full mb-4" />
                    <p class="text-gray-300 text-center">Please use the above payment details to complete your payment. Upload your payment proof in the form above for verification.</p>
                </div>
            </div>
        </div>

        <?php if (!empty($payment_submissions)) : ?>
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Payment History</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="px-4 py-2 text-left text-gray-300">Date</th>
                                <th class="px-4 py-2 text-left text-gray-300">Plan</th>
                                <th class="px-4 py-2 text-left text-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payment_submissions as $submission) : 
                                $plan = get_post_meta($submission->ID, 'plan_type', true);
                                $status = get_post_meta($submission->ID, 'payment_status', true);
                                $status_class = '';
                                
                                switch ($status) {
                                    case 'approved':
                                        $status_class = 'bg-green-800 text-green-200';
                                        break;
                                    case 'rejected':
                                        $status_class = 'bg-red-800 text-red-200';
                                        break;
                                    default:
                                        $status_class = 'bg-yellow-800 text-yellow-200';
                                        break;
                                }
                            ?>
                            <tr class="border-t border-gray-700">
                                <td class="px-4 py-3"><?php echo get_the_date('F j, Y', $submission->ID); ?></td>
                                <td class="px-4 py-3"><?php echo ucfirst(esc_html($plan)); ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 rounded <?php echo $status_class; ?>">
                                        <?php echo ucfirst(esc_html($status)); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
    
    // Check for selected plan in URL parameters
    const selectedPlan = getUrlParameter('selected_plan');
    if (selectedPlan) {
        const planSelector = document.getElementById('plan_type');
        if (planSelector) {
            // Set the dropdown to the selected plan
            for (let i = 0; i < planSelector.options.length; i++) {
                if (planSelector.options[i].value === selectedPlan) {
                    planSelector.selectedIndex = i;
                    break;
                }
            }
            
            // Scroll to the payment form section
            const paymentForm = planSelector.closest('form');
            if (paymentForm) {
                paymentForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }
    
    // Check for selected plan in session storage (from pricing buttons)
    const sessionPlan = sessionStorage.getItem('selected_plan');
    if (sessionPlan && !selectedPlan) {
        const planSelector = document.getElementById('plan_type');
        if (planSelector) {
            // Set the dropdown to the selected plan
            for (let i = 0; i < planSelector.options.length; i++) {
                if (planSelector.options[i].value === sessionPlan) {
                    planSelector.selectedIndex = i;
                    break;
                }
            }
            
            // Scroll to the payment form section
            const paymentForm = planSelector.closest('form');
            if (paymentForm) {
                paymentForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            // Clear the session storage
            sessionStorage.removeItem('selected_plan');
        }
    }
    // Plan dropdown validation for coming soon plans
    const planSelector = document.getElementById('plan_type');
    const planError = document.getElementById('plan-error');
    if (planSelector && planError) {
        planSelector.addEventListener('change', function() {
            const selected = planSelector.options[planSelector.selectedIndex];
            if (selected.value === 'forex' || selected.value === 'gold') {
                planError.textContent = 'The selected plan is not available yet. Please choose an available plan.';
                planError.classList.remove('hidden');
            } else {
                planError.textContent = '';
                planError.classList.add('hidden');
            }
        });
        // Prevent form submission if coming soon plan is selected
        const paymentForm = planSelector.closest('form');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                const selected = planSelector.options[planSelector.selectedIndex];
                if (selected.value === 'forex' || selected.value === 'gold') {
                    planError.textContent = 'The selected plan is not available yet. Please choose an available plan.';
                    planError.classList.remove('hidden');
                    e.preventDefault();
                }
            });
        }
    }
});
</script>

<?php get_footer(); ?>

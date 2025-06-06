<?php
/*
Template Name: Affiliate
*/
get_header();
?>
<main style="min-height:100vh;display:flex;flex-direction:column;">
    <div style="flex:1 0 auto;display:flex;align-items:center;justify-content:center;min-height:0;">
        <section class="w-full max-w-xl bg-gray-800 rounded-lg shadow-lg p-8 mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center gradient-text">Become an Affiliate</h1>
            <?php if (isset($_GET['affiliate_error'])): ?>
                <div class="mb-4 p-3 bg-red-800 text-red-200 rounded-md text-center">
                    <?php echo esc_html(urldecode($_GET['affiliate_error'])); ?>
                </div>
            <?php elseif (isset($_GET['affiliate_success'])): ?>
                <div class="mb-4 p-3 bg-green-800 text-green-200 rounded-md text-center">
                    Your affiliate application has been submitted successfully!
                </div>
            <?php endif; ?>
            <form id="affiliate-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-ajax="true">
                <input type="hidden" name="action" value="affiliate_form">
                <?php wp_nonce_field('affiliate_form_nonce', 'affiliate_form_nonce'); ?>
                <div class="mb-4">
                    <label for="affiliate_email" class="block text-sm font-medium text-gray-300 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="affiliate_email" name="email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="affiliate_first_name" class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                    <input type="text" id="affiliate_first_name" name="name" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="affiliate_password" class="block text-sm font-medium text-gray-300 mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="affiliate_password" name="affiliate_password" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="affiliate_password_confirm" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" id="affiliate_password_confirm" name="affiliate_password_confirm" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label for="affiliate_paypal" class="block text-sm font-medium text-gray-300 mb-1">PayPal Email Address</label>
                    <input type="email" id="affiliate_paypal" name="paypal" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="For commission payouts">
                </div>
                <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-full transition duration-300">APPLY FOR AFFILIATE PROGRAMME</button>
            </form>
        </section>
    </div>
</main>
<?php get_footer(); ?>

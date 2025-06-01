<?php
/*
Template Name: Academy
*/
get_header();

// Include modals
get_template_part('modals');
?>
<main>
    <section class="py-16 bg-gray-900 min-h-screen">
        <main class="max-w-3xl mx-auto py-32 px-4 text-center">
        <div class="mb-10">            <h1 class="text-4xl md:text-5xl font-bold mb-4 gradient-text">Academy</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">Unlock your trading potential with our upcoming Stallion Signal Pro Academy. Comprehensive video lessons, interactive tutorials, and expert strategies are on the way!</p>
        </div>
        <div class="bg-gray-800 rounded-lg p-12 shadow-lg flex flex-col items-center">
            <i class="fas fa-graduation-cap text-blue-400 text-6xl mb-6"></i>
            <h2 class="text-3xl font-semibold mb-4">Coming Soon!</h2>
            <p class="text-gray-300 text-lg mb-6">Our all-in-one trading academy is launching soon. Stay tuned for in-depth tutorials, live webinars, and exclusive resources to help you master Crypto and Forex trading with Stallion Signal Pro.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium transition duration-300 glow">Back to Home</a>
        </div>
    </main>

    </section>
</main>
<?php get_footer(); ?>

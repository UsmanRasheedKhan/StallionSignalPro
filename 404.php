<?php get_header(); ?>
<main>
    <section class="py-16 bg-gray-900 min-h-screen flex flex-col items-center justify-center">
        <h1 class="text-5xl font-bold gradient-text mb-8">404</h1>
        <p class="text-gray-300 text-xl mb-6">Sorry, the page you are looking for could not be found.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-md text-white font-medium transition duration-300">Go Home</a>
    </section>
</main>
<?php get_footer(); ?>

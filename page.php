<?php get_header(); ?>
<main>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    else :
    ?>
        <section class="py-16 bg-gray-900 min-h-screen flex flex-col items-center justify-center">
            <h1 class="text-3xl font-bold gradient-text mb-8">No Content Found</h1>
            <p class="text-gray-300 text-xl mb-6">Sorry, there is nothing to display here.</p>
        </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

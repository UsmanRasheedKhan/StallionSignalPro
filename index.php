<?php get_header(); ?>
<main>
    <div class="max-w-3xl mx-auto py-16 px-4">
        <h1 class="text-3xl font-bold mb-6"><?php the_title(); ?></h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="prose text-gray-200">
                <?php the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </div>
</main>
<?php get_footer(); ?>

<?php get_header('portfolio-page'); ?>

    <div class="content-main">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <?php $category = get_the_category(); ?>
            <?php if ($category[0]->cat_name != "Portfolio"): ?>
                <h1><?php the_title() ?></h1>
            <?php endif; ?>

            <?php the_content() ?>

        <?php endwhile; ?>
            <!-- post navigation -->
        <?php else: ?>
            <!-- no posts found -->
        <?php endif; ?>

    </div>

<?php get_footer(); ?>
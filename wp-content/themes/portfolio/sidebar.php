<div class="sidebar">
    	<div>

<?php $args = array(
                    'post-type' => 'post',
                    'orderby' => 'rand',
                    'category_name' => 'photo-shoot,exhibitions',
                    'posts_per_page' => 1); ?>

<?php $rand_post = new WP_Query($args); ?>
<?php if ( $rand_post->have_posts() ) : while ( $rand_post->have_posts() ) : $rand_post->the_post(); ?>

<a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
<?php the_excerpt(); ?>
<p><a href="<?php the_permalink() ?>" class="read-more">read more</a></p>

<?php endwhile; ?>
<!-- post navigation -->
<?php else: ?>
<!-- no posts found -->
<?php endif; ?>
        </div>
    </div>
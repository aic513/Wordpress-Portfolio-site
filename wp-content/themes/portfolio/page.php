<?php get_header('page'); ?>
<div class="content-main">

	<div class="content-left">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<h1><?php the_title() ?></h1>
<?php the_content(); ?>

<?php endwhile; ?>
<!-- post navigation -->
<?php else: ?>
<!-- no posts found -->
<?php endif; ?>

    </div>
    
    <div class="sidebar">
    	<div>
        	<a href="#"><img src="<?php bloginfo('template_url') ?>/images/side-img1.jpg" alt="" /></a>
            <h1><a href="#">Skill Set</a></h1>
            <p>Sed dolor ligula, tempus vitae malesuada utescu
congue vitae diam. Integer non nisl est. Suspen
isse at diam turpis, ut mattis velit. Praesent vel est non augue pretium condimentum at in mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in varius ante. Etiam et nisi eget velit dignissim gravida ac nec quam. Aenean imperdiet massa quis diam tempunec.</p>
            <p><a href="#" class="read-more">read more</a></p>
        </div>
    </div>
            
</div>
<?php get_footer('page'); ?>
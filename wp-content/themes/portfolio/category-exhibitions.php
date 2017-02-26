<?php get_header(); ?>
<div class="content-main">


	<div class="content-main-blocks">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div>
	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
    <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
    <p class="ex-place">King’s Museum, Kensington, London</p>
	<p class="ex-date">Tues 26th April 2011 - Sat 30th April 2011
8am to 9pm with free refreshments.</p>
	<p class="ex-ticket">Buy tickets from <a href="#">TicketMaster</a></p>
    <?php the_excerpt() ?>
    <p><a href="<?php the_permalink() ?>" class="read-more"> Read more</a></p>
</div>

<?php endwhile; ?>
<!-- post navigation -->
<?php else: ?>
<!-- no posts found -->
<?php endif; ?>



    </div>
    
            
</div>
<?php get_footer(); ?>
<?php
/*
Template Name: Шаблон страницы контактов
*/
?>
<?php get_header('page'); ?>
<div class="content-main">

	<div class="content-left">
		
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<h1><?php the_title() ?></h1>
<div class="contact-form">
	<?php the_content() ?>
</div>

<?php endwhile; ?>
<!-- post navigation -->
<?php else: ?>
<!-- no posts found -->
<?php endif; ?>

	</div>

	<div class="sidebar">
        	<div>
            	<img src="images/contact-img.jpg" alt="" />
                <h1>Contact Details</h1>
                <p class="contact-address">18, Your Street, Yourareaname, Cityname,
                Countyname, DE1 2WX, United Kingdom.</p>
                
                <p class="contact-phone">0800 900 0003</p>
                
                <p class="contact-mail">youremail@yoursite.com</p>
                
                <p class="contact-liciense">Registered photographer No. 09900-CCC</p>
                
                <p>VAT registered business number 455-5559-000</p>

            </div>
        </div>
            
</div>
<?php get_footer('page'); ?>
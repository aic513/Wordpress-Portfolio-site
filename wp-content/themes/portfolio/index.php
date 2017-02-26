<?php get_header(); ?>
	<div class="content-main">

		<!-- Elastislide Carousel -->
		<?php if(!dynamic_sidebar( 'slider_index' )): ?>
			<ul id="carousel" class="elastislide-list">
				<li>Место для карусели</li>
			</ul>
		<?php endif; ?>
		<!-- End Elastislide Carousel -->

		<div class="content-main-blocks">

			<?php $args = array( 'post_type' => array('post', 'page'),
			                     'meta_key' => 'order',
			                     'orderby' => 'meta_value_num',
			                     'order' => 'ASC',
			                     'posts_per_page' => 3 ); ?>
			<?php $page_index = new WP_Query($args); ?>

			<?php if ( $page_index->have_posts() ) : while ( $page_index->have_posts() ) : $page_index->the_post(); ?>

				<div>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
					<h1><a href="<?php the_permalink(); ?>"><?php echo get_post_meta( get_the_ID(), 'title', true ) ?></a></h1>
					<?php the_excerpt(); ?>
					<p><a href="<?php the_permalink(); ?>" class="read-more">read more</a></p>
				</div>

			<?php endwhile; ?>
				<!-- post navigation -->
			<?php else: ?>
				<div>
					<p>Добавьте к страницам/записям произвольное поле "title" с неободимым заголовком для вывода на главную страницу</p>
					<p>Второе произвольное поле - "order" - будет использовано для сортировки</p>
				</div>
				<div>
					<p>Добавьте к страницам/записям произвольное поле "title" с неободимым заголовком для вывода на главную страницу</p>
					<p>Второе произвольное поле - "order" - будет использовано для сортировки</p>
				</div>
				<div>
					<p>Добавьте к страницам/записям произвольное поле "title" с неободимым заголовком для вывода на главную страницу</p>
					<p>Второе произвольное поле - "order" - будет использовано для сортировки</p>
				</div>
			<?php endif; ?>


		</div>
	</div>
	</div>
<?php get_footer(); ?>
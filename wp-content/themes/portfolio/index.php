<?php get_header(); ?>
	<div class="content-main">

		<!-- Elastislide Carousel -->
		<?php if ( ! dynamic_sidebar( 'slider_index' ) ): ?>
			<ul id="carousel" class="elastislide-list">
				<li>Место для карусели</li>
			</ul>
		<?php endif; ?>
		<!-- End Elastislide Carousel -->

		<div class="content-main-blocks">

			<div>
				<a href="#"><img src="<?php bloginfo( 'template_url' ) ?>/images/mail-news1.jpg" alt=""/></a>
				<h1><a href="#">Hi, My Name Is Anne Photographer</a></h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisi odio, sollicitudin at
					condimentum at, mattis a ligula. </p>

				<p>Ut vitae urna quis massa consectetur cursus ultricies in tellus. Aliquam sed odio in neque mattis
					laoreet. Cras lacus purus,</p>
				<p><a href="#" class="read-more">read more</a></p>
			</div>

			<div>
				<a href="#"><img src="<?php bloginfo( 'template_url' ) ?>/images/mail-news2.jpg" alt=""/></a>
				<h1><a href="#">Exhibition Now On</a></h1>
				<p>Nam egestas sapien molestie lorem auctor eget scelerisque neque tincidunt. Ut iaculis leo non sem can
					<a href="#">this is an inline link</a>. Maecenas mi massa, interdum at sagittis eu, imperdiet a dui.
					Duis sit amet tortor leo. Fusce tempor pellentesque mollis. Sed tincidunt elit sit amet ipsum
					fermentum venenatis.</p>
				<p><a href="#" class="read-more">read more</a></p>
			</div>

			<div>
				<a href="#"><img src="<?php bloginfo( 'template_url' ) ?>/images/mail-news3.jpg" alt=""/></a>
				<h1><a href="#">Latest Photo Shoot</a></h1>
				<p>Donec mollis suscipit nisi, vitae sagittis arcu euismod at. In at turpis vel odio fringilla vulputate
					at ac tellus. Phasellus nulla leo, vehicula sit amet congue eget, viverra ut augue epharetra aliquet
					turpis vel scelerisque.
					Nullam ut enim nisi. Vivamus ut neque nulla. est aliquam consectetur augue et est dapibus ;</p>
				<p><a href="#" class="read-more">read more</a></p>
			</div>

		</div>
	</div>
	</div>
<?php get_footer(); ?>
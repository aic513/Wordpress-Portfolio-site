<div class="footer-wrapper">
	<div class="footer-main">
    	<div class="foter-left">
            <a href="/"><img src="<?php bloginfo('template_url') ?>/images/logo-ftr.jpg" alt="" /></a>
            <p>copyright 2011 <a href="#">www.yoururl.com</a></p>
        </div>
        <div class="foter-right">
	        <?php if(!dynamic_sidebar( 'footer' )): ?>
			        <p style="color:white">Место для футера (добавить через текст)</p>
	        <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.elastislide.js"></script>
<script type="text/javascript">
		
	$( '#carousel' ).elastislide();
			
</script>
<?php wp_footer(); ?>
</body>
</html>
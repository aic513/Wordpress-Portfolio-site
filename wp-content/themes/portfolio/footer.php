<div class="footer-wrapper">
    <div class="footer-main">
        <div class="foter-left">
            <a href="/"><img src="<?php bloginfo('template_url') ?>/images/logo-ftr.jpg" alt="" /></a>
            <p>copyright 2011 <a href="#">www.yoururl.com</a></p>
        </div>
        <div class="foter-right">
            <?php if(!dynamic_sidebar( 'footer' )): ?>
                <p style="color: #FEFCFC">Добавьте содержимое через виджет Текст</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquerypp.custom.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.elastislide.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.liSlidik.js"></script>
<script type="text/javascript">

    $( '#carousel' ).elastislide();

    $(function(){
        $(window).load(function(){
            $('#slide_2').liSlidik({
                auto:3000,
                duration: 1000
            });
        })
    });

</script>
<?php wp_footer(); ?>
</body>
</html>
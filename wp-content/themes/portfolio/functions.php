<?php
/*
 * Создание меню
 */

register_nav_menu( 'menu', 'Primary Menu' );

/*
 * Создание слайдера
 */
register_sidebar(array(
	'name' => 'Слайдер на главной странице',
	'id' => 'slider_index',
	'description' => 'Добавьте слайдер через виджет Текст',
	'before_widget' => '',
	'after_widget' => ''));
/*
 * Добавляем миниатюру
 */
add_theme_support('post-thumbnails');

/*
 * Для футера
 */
register_sidebar(array(
	'name' => 'Футер',
	'id' => 'footer',
	'description' => 'Добавьте ссылки на соцсети через виджет Текст',
	'before_widget' => '',
	'after_widget' => ''));

/*
 * shortcode галлереи
 */

function portfolio_gallery($attr, $text=''){
	// получаем массив ID картинок
	$img_src = explode(",", $attr['ids']);
	// шаблон удаления атрибутов width/height
	$pattern = '#(width|height)="\d+"#';
	$return = '<ul id="slide_2" class="slidik">';
	// счетчик
	$i = 1;
	foreach ($img_src as $item) {
		// получаем HTML-код картинки
		$image_url = wp_get_attachment_image( $item, 'full' );
		// вырезаем атрибуты width/height
		$image_url = preg_replace($pattern, "", $image_url);
		// формируем вывод картинок
		if($i == 1) $return .= '<li class="show">' . $image_url . '</li>';
		else $return .= '<li>' . $image_url . '</li>';
		$i++;
	}
	$return .= '<a data-slidik="slide_2" class="next" href="#">Next</a>
            <a data-slidik="slide_2" class="prev" href="#">Prev</a>
            <div class="captionWrap"><div data-slidik="slide_2" class="caption"></div></div>
            <div class="portfolio-close"><a href="#"></a></div>
    	</ul>';
	echo $return;
}
add_shortcode('shortcode_gallery', 'portfolio_gallery');
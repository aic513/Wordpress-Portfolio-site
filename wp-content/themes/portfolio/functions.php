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
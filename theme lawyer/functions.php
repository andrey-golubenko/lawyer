<?php
//РАЗРЕШАЕМ ЗАГРУЗКУ ЗАПРЕЩЁННОГО ФОРМАТА ИЗОБРАЖЕНИЙ
add_filter( 'upload_mimes', 'upload_allow_types' );
function upload_allow_types( $mimes ) {
	// разрешаем новые типы
	$mimes['svg']  = 'text/plain'; // image/svg+xml
	$mimes['doc']  = 'application/msword'; 
	$mimes['woff'] = 'font/woff';
	$mimes['psd']  = 'image/vnd.adobe.photoshop'; 
	$mimes['djv']  = 'image/vnd.djvu';
	$mimes['djvu'] = 'image/vnd.djvu';
	$mimes['webp'] = 'image/webp';
	$mimes['webm'] = 'video/webm';
 	// МОЖЕМ отключить имеющиеся
	// unset( $mimes['mp4a'] );
	return $mimes;
}
// Убираем админ-бар с основной страници
add_filter('show_admin_bar', '__return_false');
// Устанавливаем КОНСТАНТЫ для путей располоэжения подключаемых файлов стилей и js (чтоб меньше писать)
define('A_THEM_ROOT', get_template_directory_uri());
define('A_CSS_DIR', A_THEM_ROOT . '/assets/css');
define('A_JS_DIR', A_THEM_ROOT . '/assets/js');
define('A_IMG_DIR', A_THEM_ROOT . '/assets/images');
								/**** Подключаем СТИЛИ и СКРИПТЫ ****/
add_action('wp_enqueue_scripts', 'lawyer_media' );
function lawyer_media (){
	wp_enqueue_style('font-poppins', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap');
	wp_enqueue_style('font-lora', 'https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap');
// 	wp_enqueue_style('lawyer-iconBoot', A_CSS_DIR . '/open-iconic-bootstrap.min.css');
// 	wp_enqueue_style('lawyer-animate', A_CSS_DIR . '/animate.css');
// 	wp_enqueue_style('lawyer-owlCarousel', A_CSS_DIR . '/owl.carousel.min.css');
// 	wp_enqueue_style('lawyer-owlTheme', A_CSS_DIR . '/owl.theme.default.min.css');
// 	wp_enqueue_style('lawyer-popup', A_CSS_DIR . '/magnific-popup.css');
// 	wp_enqueue_style('lawyer-ionicons', A_CSS_DIR . '/ionicons.min.css');
// 	wp_enqueue_style('lawyer-flaticon', A_CSS_DIR . '/flaticon.css');
// 	wp_enqueue_style('lawyer-icomoon', A_CSS_DIR . '/icomoon.css');
	wp_enqueue_style('lawyer-styles', get_stylesheet_uri());
/** Оставляем JQ (джейквери) вшитую в WP. JQ и jQ-migrate, которые идут с вёрсткой удаляем, чтобы не было конфликта с плагином (jQ-form) при отправке писем из формы обратной связи. **/
	wp_enqueue_script( 'jquery');
	wp_enqueue_script('lawyer-stellar', A_JS_DIR . '/jquery.stellar.min.js', [], null, true);//Добовляет паралакс эффект
	wp_enqueue_script('lawyer-scrollax', A_JS_DIR . '/scrollax.min.js', [], null, true);//Паралакс эффекты тоже
	wp_enqueue_script('lawyer-waypoints', A_JS_DIR . '/jquery.waypoints.min.js', [], null, true);//Прилипание эллементов к месту при скроле (меню)
	wp_enqueue_script('lawyer-owl-carousel', A_JS_DIR . '/owl.carousel.min.js', [], null, true);
	wp_enqueue_script('lawyer-popup', A_JS_DIR . '/jquery.magnific-popup.min.js', [], null, true);
	wp_enqueue_script('lawyer-animateNum', A_JS_DIR . '/jquery.animateNumber.min.js', [], null, true);
	wp_enqueue_script('lawyer-bootstrap', A_JS_DIR . '/bootstrap.min.js', [], null, true);//Выпадающеее меню в адаптиве и т.д.		
	if( is_singular() && comments_open() && (get_option('thread_comments') == 1) ){
		wp_enqueue_script('comment-reply', '', ['jquery'], '', true);
	    wp_enqueue_script( 'lawyer-comments', A_JS_DIR . '/comments.js', ['jquery'], null, true );
	};
	// Обрабтка полей БОЛЬШОЙ И МАЛОЙ формы ОБРАТНОЙ СВЯЗИ
	wp_enqueue_script( 'jquery-form');
	wp_enqueue_script('lawyer-main', A_JS_DIR . '/main.js', [], null, true);
	// Задаем данные обьекта ajax
	wp_localize_script('lawyer-main', 'feedback_object',
		array(
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'feedback-nonce' ),
		)
	);
	//ОТЛЮЧАЕМ Скрипты из header  и ПЕРЕПОДКЛЮЧАЕМ ИХ В footer
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
};
//ПОДКЛЮЧАЕМ СКРИПТ(js) Кастомных Полей в АДМИНКУ
add_action( 'admin_enqueue_scripts', function(){
	wp_enqueue_script('custom-admin-fields', A_JS_DIR . '/custom-admin-fields.js', ['jquery'], null, true);
}, 99 );
//ДОБОВЛЯЕМ ко ВСЕМ или НЕКОТОРЫМ подключенным СКРИПТАМ отрибут 'deffer' и/или 'async'.
add_filter( 'script_loader_tag', function ( $tag, $handle, $src ){
    //Ко многим подключонным скриптам
    $handlers = ['lawyer-main', 'lawyer-scrollax', 'lawyer-animateNum', 'lawyer-popup', 'lawyer-owl-carousel', 'lawyer-stellar', 'lawyer-waypoints', 'lawyer-bootstrap', 'jquery-form', 'jquery-migrate', 'wp-embed', 'comment-reply', 'lawyer-comments'];
    foreach($handlers as $defer_script){
        if( $defer_script === $handle){
        	return str_replace( ' src', ' defer src', $tag );
        }
    }
    return $tag;
}, 10, 3 );
// REMOVE EMOJI ICONS (УДАЛИТЬ ИКОНКИ эмоджи ИЗ АДМИНКИ)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
//На ХУК "after_setup_theme - после установки темы" вешаем свою ф-цию в которой находятся ф-ции,  которые
// 1) регистрирует МЕНЮ,
// 2) самостоят. генерирует тег "title" в "header",
// 3) даёт возможность установки картинки в постах,
add_action('after_setup_theme', 'lawyer_after_setup');
function lawyer_after_setup (){
	load_theme_textdomain('lawyer');
	register_nav_menus([
		'top' => 'Для шапки',
		]);         //регстрация header-меню
	add_theme_support('title-tag');//самостоят. генерация тега title в header
	add_theme_support('post-thumbnails');//возможность установки картинок во всех типах постов
	set_post_thumbnail_size(730, 487);//размеры картинок для Больш постов
	add_image_size( 'lawyer-small-recent-post', 78, 80, true ); //размеры картинок для Малых постов в САЙДБАРЕ
	add_theme_support('html5', array( 'search_form', 'comment-form', 'comment-list', 'gallery', 'caption') ); //Включает поддержку html5 разметки для списка комментариев, формы комментариев, формы поиска, галереи, фигур и т.д. Где нужно включить разметку указывается во втором параметре.	
}
//В функции ВЫВОДА ВИДЕО (wp_video_shortcode();) убираем генерируемые ею ненужные нам отрибуты в тегах 'div' и 'video' посредством замены.
add_filter( 'wp_video_shortcode', function( $output ) {
	$output = str_replace( ['<div style="width: 640px;"', 'width="640"', 'height="360"'], ['<div', '',''], $output );
	return $output;
} );									
													/** МЕНЮ **/
// // МЕНЮ Изменение атрибута id у тега li
add_filter('nav_menu_item_id', 'filter_menu_item_css_id', 10, 4);
function filter_menu_item_css_id ($menu_id, $item, $args, $depth){
	return $args->theme_location === 'top' ? '' : $menu_id;}
// // МЕНЮ Изменение атрибута class у тега li
add_filter('nav_menu_css_class', 'filter_menu_item_css_classes', 10, 4);
function filter_menu_item_css_classes($classes, $item, $args, $depth){
	if ($args->theme_location === 'top'){
		$classes = [ 'nav-item', ];
		if($item->current){
			$classes [] = 'active';
		}
	}
	return $classes;
}
//МЕНЮ Изменение класса ссылкам
add_filter('nav_menu_link_attributes','filter_nav_menu_link_attributes', 10, 4);
function filter_nav_menu_link_attributes($atts, $item, $args, $depth){
	if ($args->theme_location === 'top'){
		$atts ['class'] = 'nav-link';
	}
	return $atts;
}
//УБИРАЕМ НАЗВАНИЕ САЙТА (кот. ф-ция дописывает через тире) из заголовка в header на остальных стрaницах (кроме Главной).
add_filter( 'document_title_parts', function( $parts ){
	if( isset($parts['site']) ) unset($parts['site']);
	return $parts;
});	
//ВЫВОДИМ в шаблон (front-page) ВСЕ обычные ПОСТЫ т.е. новости
function get_posts_simple($amount_posts = -1){// "-1" - НЕОГРАНИЧЕННОЕ кол-во постов на странице, указываем по умолчанию, а в шаблоне меняем на нужное нам кол-во
	return get_posts( array(
		'numberposts' => $amount_posts,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => 'post',
		'post_status' => array( 'publish' ),
	) );
}
// ОБРЕЗКА ТЕКСТА (excerpt). Шоткоды вырезаются. Минимальное значение maxchar может быть 22.
function kama_excerpt( $args = '' ){
	global $post;
	if( is_string($args) )
		parse_str( $args, $args );
	$rg = (object) array_merge( array(
		'maxchar'     => 350,   // Макс. количество символов.
		'text'        => '',    // Какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
		// Если в тексте есть `<!--more-->`, то `maxchar` игнорируется и берется
		// все до <!--more--> вместе с HTML.
		'autop'       => false,  // Заменить переносы строк на <p> и <br> или нет?
		'save_tags'   => '',    // Теги, которые нужно оставить в тексте, например '<strong><b><a>'.
		'more_text'   => '', //'Читать далее...', // Текст ссылки `Читать дальше`.
		'ignore_more' => false, // нужно ли игнорировать <!--more--> в контенте
	), $args );

	$rg = apply_filters( 'kama_excerpt_args', $rg );
	if( ! $rg->text )
		$rg->text = $post->post_excerpt ?: $post->post_content;
	$text = $rg->text;
	// убираем блочные шорткоды: [foo]some data[/foo]. Учитывает markdown
	$text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text );
	// убираем шоткоды: [singlepic id=3]. Учитывает markdown
	$text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text );
	$text = trim( $text );

	// <!--more-->
	if( ! $rg->ignore_more  &&  strpos( $text, '<!--more-->') ){
		preg_match('/(.*)<!--more-->/s', $text, $mm );
		$text = trim( $mm[1] );
		$text_append = ' <a href="'. get_permalink( $post ) .'#more-'. $post->ID .'">'. $rg->more_text .'</a>';
	}
	// text, excerpt, content
	else {
		$text = trim( strip_tags($text, $rg->save_tags) );
		// Обрезаем
		if( mb_strlen($text) > $rg->maxchar ){
			$text = mb_substr( $text, 0, $rg->maxchar );
			$text = preg_replace( '~(.*)\s[^\s]*$~s', '\\1', $text ); // кил последнее слово, оно 99% неполное
			$text .= ' <a href="'. get_permalink($post->ID) .'"><b>     .   .   . </b></a>';
		}
	}
	// сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $rg->autop ){
		$text = preg_replace(
			array("/\r/", "/\n{2,}/", "/\n/",   '~</p><br ?/?>~'),
			array('',     '</p><p>',  '<br />', '</p>'),
			$text
		);
	}
	$text = apply_filters( 'kama_excerpt', $text, $rg );
	if( isset($text_append) )
		$text .= $text_append;
	return ( $rg->autop && $text ) ? "<p>$text</p>" : $text;
}
//РЕГИСТРАЦИЯ САЙДБАРА
add_action( 'widgets_init', 'register_lawyer_widgets' );
function register_lawyer_widgets(){
	register_sidebar( array(
		'name'          => sprintf(__('Sidebar %d', 'lawyer'), 1 ),
		'id'            => "sidebar-1",
		'description'   => 'Сайдбар для страници отображения одиночных постов',
		'class'         => '',
		'before_widget' => '<div id="%1$s" class="sidebar-box ftco-animate %2$s">',
		'after_widget'  => "</div>",
		'before_title'  => '<h3>',
		'after_title'   => "</h3>",
	) );
}
//ИЗМЕНЕНИЕ ВИДЖЕТА КАТЕГОРИЙ
add_filter('widget_categories_args', 'lawyer_widget_categories');
function lawyer_widget_categories($args){
	$walker = new Lawyer_Walker_Category();
	$args = array_merge($args, array('walker' => $walker, 'hide_empty' => 0, 'exclude' => 1));
	return $args;
}
                         			   /***** ВИДЖЕТ ПОИСКА *****/
//ИЗМЕНЯЕМ HTML ФОРМЫ ПОСИКА (в том числе и в ВИДЖЕТЕ ПОИСКА)
add_filter( 'get_search_form', 'my_search_form' );
function my_search_form( $form ) {
	$form = '
	<form role="search" method="get" id="searchform" class="search-form" action="' . home_url( '/' ) . '" >
        <div class="form-group">
            <input type="text" value="' . get_search_query() . '" name="s" id="s" class="form-control" placeholder="Ввидите слово и нажмите Enter " />
            <span class="icon icon-search"></span>
            <!--<input type="submit" id="searchsubmit" value=""/>-->
        </div>
	</form>';
	return $form;
}
//ФИЛЬТР ПАГИНАЦИИ ДЛЯ ВИДЖЕТА ПОИСКА
// удаляет H2 из шаблона пагинации
add_filter('navigation_markup_template', 'widget_nav_template', 10, 2 );
function widget_nav_template( $template, $class ){
	return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>
	';
}
// РЕГИСТРАЦИЯ СВОЕГО ВИДЖЕТА ПОСЛЕДНИХ ПОСТОВ
add_action( 'widgets_init', 'lawyer_register_widget' );
function lawyer_register_widget() {
	register_widget( 'Lawyer_Widget_Recent_Posts' );//КЛАСС по которому работает виджет и кот. расположен в папке 'inc'.
}
							/** ФУНКЦИЯ для ПОДСВЕТКИ СЛОВ ПОИСКА в WordPress **/
add_filter( 'the_content', 'kama_search_backlight' );
add_filter( 'kama_excerpt', 'kama_search_backlight' );
add_filter( 'the_title', 'kama_search_backlight' );
function kama_search_backlight( $text ){
// Настройки -----------
$styles = ['',
'color: #000; background: #99ff66;',
'color: #000; background: #ffcc66;',
'color: #000; background: #99ccff;',
'color: #000; background: #ff9999;',
'color: #000; background: #FF7EFF;',
];
// только для страниц поиска...
if ( ! is_search() )
	return $text;
$query_terms = get_query_var('search_terms');
if( empty($query_terms) )
	$query_terms = array_filter( [ get_query_var('s') ] );
if( empty($query_terms) )
	return $text;
$n = 0;
foreach( $query_terms as $term ){
    $n++;
    $term = preg_quote( $term, '/' );
    $text = preg_replace_callback( "/$term/iu", function($match) use ($styles,$n){
    return '<span style="'. $styles[ $n ] .'">'. $match[0] .'</span>';
    },
        $text );
}
return $text;
}
				## Отключает новый редактор блоков в WordPress (Гутенберг).
## ver: 1.0
if( 'disable_gutenberg' ){
    add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
    // отключим подключение базовых css стилей для блоков
    // ВАЖНО! когда выйдут виджеты на блоках или что-то еще, эту строку нужно будет комментировать
    remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
    // Move the Privacy Policy help notice back under the title field.
    add_action( 'admin_init', function(){
        remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
        add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
    } );
}
## Удаление файлов license.txt и readme.html для защиты
if( is_admin() && ! defined('DOING_AJAX') ){
	$license_file = ABSPATH .'/license.txt';
	$readme_file = ABSPATH .'/readme.html';
	if( file_exists($license_file) && current_user_can('manage_options') ){
		$deleted = unlink($license_file) && unlink($readme_file);
		if( ! $deleted  )
			$GLOBALS['readmedel'] = 'Не удалось удалить файлы: license.txt и readme.html из папки `'. ABSPATH .'`. Удалите их вручную!';
		else
			$GLOBALS['readmedel'] = 'Файлы: license.txt и readme.html удалены из из папки `'. ABSPATH .'`.';
		add_action( 'admin_notices', function(){  echo '<div class="error is-dismissible"><p>'. $GLOBALS['readmedel'] .'</p></div>'; } );
	}
}
## Полное Удаление версии WP
## Также нужно удалить файл readme.html в корне сайта
remove_action('wp_head', 'wp_generator'); // из заголовка
add_filter('the_generator', '__return_empty_string'); // из фидов и URL
add_filter( 'script_loader_src', 'remove_wp_version_strings' ); // из версий скриптов
add_filter( 'style_loader_src', 'remove_wp_version_strings' ); // из версий стилей
function remove_wp_version_strings( $src ) {
	 parse_str( parse_url($src, PHP_URL_QUERY), $query );
	 if ( !empty($query['ver']) && $query['ver'] === $GLOBALS['wp_version'] ) {
		  $src = remove_query_arg( 'ver', $src );
	 }
	 return $src;
}
// Отключим выводи ошибок на странице авторизации
add_filter('login_errors', 'login_obscure_func');
function login_obscure_func(){
	return 'Ошибка: вы ввели неправильный логин или пароль.';
}
## ЗАКРОЕМ возможность публикации через xmlrpc.php (через почту)
add_filter('xmlrpc_enabled', '__return_false');
/* ПОДКЛЮЧАЕМ КЛАСС ДЛЯ ВИДЖЕТА Последних Постов */
require get_template_directory() . '/inc/class-lawyer-recent-posts-widget.php'; //Если ранее уже был подключён, то всё равно подключтся (в отличии от require_once, который проверит был ди ранее подключёт файл). В случае содержания в себе ошибки? выдаст её и весь скрипт function.php остановится (в отличии от include, который выдаст не фатальную ошибку и продолжит выполнение скрипта function.php)
/* ПОДКЛЮЧАЕМ КЛАСС ДЛЯ ВИДЖЕТА Категорий */
require get_template_directory() . '/inc/class-lawyer_Walker_Category.php';
/* ПОДКЛЮЧАЕМ  КАСТОМАЙЗЕР */
require get_template_directory() . '/inc/customizer.php';
/* ПОДКЛЮЧАЕМ ФУНКЦИИ ДЛЯ КОММЕНТАРИЕВ ( кастомная коммент. форма, обработка каждого поступившего коммента, структура каждого коммента) */
require get_template_directory() . '/inc/comment-functions.php';
/* ПОДКЛЮЧАЕМ  ДВЕ ФОРМЫ ОБРАТНОЙ СВЯЗИ И ПОДПИСКИ И ИХ ОБРАБОТЧИКИ */
require get_template_directory() . '/inc/feedback-forms.php';
/* ПОДКЛЮЧАЕМ  ТИПЫ ЗАПИСЕЙ 'team' and 'clients' И КАСТОМНЫЕ ПОЛЯ К НИМ */
require get_template_directory() . '/inc/custom-post-types.php';
/* ПОДКЛЮЧАЕМ  BREADCRUMBS ОБРАБОТЧИК */
require get_template_directory() . '/inc/breadcrumbs-handler.php';
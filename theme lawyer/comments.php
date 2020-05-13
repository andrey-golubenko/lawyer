<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Lawyer
 * @since Lawyer 1.0
 */ 
if ( post_password_required() )
	return;
?>
<div id="comments" class="">
	<?php if ( have_comments() ) : ?>
		<h3 class="mb-5"><?php printf( _nx( 'Один Комментарий"', 'Комментариев %1$s', get_comments_number(), 'comments title', 'lawyer' ),// _nx () - ПЕРЕВОДИТ и возвращает единственную или множественную форму числа (у нас кол-ва комментариев) на основе указанного контекста.
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); //Конвертирует число (целое или дробное) в формат подходящий к текущему языку сайта то есть на русский манер - 10 000, 55 или на английский манер - 10,000.55 . ?></h3>
		<ul class="commentlist">
			<?php wp_list_comments(array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => 50,
				'callback'    => 'lawyer_list_comments',
				'max_depth'   => 4,
				'type'        =>'comment'
			)); ?>
		</ul>
		<?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
			<nav class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'lawyer' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&amp;larr; Older Comments', 'lawyer' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &amp;rarr;', 'lawyer' ) ); ?></div>
			</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>
		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments">Комментарии закрыты.</p>
		<?php endif; ?>
	<?php endif; ?>
	<div class="comment-form-wrap pt-5">
		<?php
		//ИЗМЕНЕНИЕ стандартного ПОРЯДКА вывода (последовательности вывода) ПОЛЕЙ лучше распологать ПЕРЕД ф-цией вывода ФОРМЫ коментариев
		add_filter('comment_form_fields', 'lawyer_reorder_comment_fields');
		function lawyer_reorder_comment_fields($fields){
			$new_fields = array();
			$myOrder = array('author', 'email', 'comment');
			foreach ($myOrder as $key){
				$new_fields[$key] = $fields [$key];
				unset($fields [$key]);
			}
			if ($fields)
				foreach($fields as $key => $val)
					$new_fields[$key] = $val;
			return $new_fields;
		}
		//ФУНКЦИЯ, которая генерирует ВЫВОД ФОРМЫ коментариев
		lawyer_comment_form();
		?>
	</div>
</div>
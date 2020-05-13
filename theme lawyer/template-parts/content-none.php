<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
?>
<div class="no-results not-found">
	<header class="page-header">
		<h3 class="page-title"><?php esc_html_e( 'Ничего не найдено', 'lawyer'); ?></h3>
	</header><!-- .page-header -->
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'lawyer' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);
		elseif ( is_search() ) :
			?>
			<p><?php esc_html_e( 'Извините, но соответствий Вашим условиям поиска не найдено. Пожалуйста, попробуйте снова, применив другие ключевыми слова.', 'lawyer'); ?></p>
			<?php
			get_search_form();
		else :
			?>
			<p><?php esc_html_e( 'Кажется мы можем &rsquo;t найти то, что Вы &rsquo;re ищете. Возможно поиск поможет Вам.', 'lawyer'); ?></p>
			<?php
			get_search_form();
		endif;
		?>
	</div><!-- .page-content -->
</div><!-- .no-results -->
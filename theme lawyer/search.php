<?php
/**
 * The template for displaying search pages
 */
?>
<?php get_header('else'); ?>
<section class="ftco-section bg-light">
	<div class="container">
		<?php if ( have_posts() ) : ?>
		<div class="row justify-content-center pb-2">
            <h3 class="page-title">
				<?php				/* translators: %s: search query. */
				printf( esc_html__( 'Результаты поиска для : "%s"', 'lawyer'), '<span>' . get_search_query() . '</span>' );?>
            </h3>
		</div>
        <div class="row d-flex">
			<?php
			while (have_posts()) : the_post();
            get_template_part( 'template-parts/content', 'search' );
			 endwhile;
			wp_reset_postdata(); // чтобы ничего не поломать
			?>
        </div>
        <div class="row mt-1">
            <div class="col text-center">
                <div class="block-27">
					<?php the_posts_pagination(array(
						'show_all' => true,
						'type' => 'list',
						'prev_next' => true,
						'prev_text' => '&lt;',
						'next_text' => '&gt;',
					) ) ; ?>
                </div>
            </div>
        </div>
        <?php else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>
	</div>
</section>
<?php get_footer();
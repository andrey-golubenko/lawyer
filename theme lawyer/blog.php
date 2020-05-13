<?php
/**
* Template name: blog
*/
?>
<?php get_header('else'); ?>

<section class="ftco-section bg-light">
	<div class="container">
		<div class="row justify-content-center pb-2">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<span class="subheading">Наш Блог</span>
				<h2 id="middle_blog">Крайние Статьи</h2>
			</div>
		</div>
		<div class="row d-flex">
            <?php
            //Определяем текущую страницу
            $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
            //Обычный запрос WP_Query
            $query_blog = new WP_Query( array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'paged' => $paged, // передаём текущую страницу сюда!
            ) );
            while ($query_blog->have_posts()) : $query_blog->the_post();
            ?>
			<div class="col-md-4 d-flex ftco-animate">
				<div class="blog-entry justify-content-end">
					<a href="<?php the_permalink() ; ?>"> 
						<div class="block-20" style="background-image: url(<?php echo get_the_post_thumbnail_url() ; ?>); background-size:cover">
						</div>
					</a>
					<div class="text p-4 float-right d-block">
						<div class="topper d-flex align-items-center">
							<div class="one py-2 pl-2 align-self-stretch">
								<span class="day"><?php the_time('d') ; ?></span>
							</div>
							<div class="two pl-2 pr-3 py-2 align-self-stretch">
								<span class="yr"><?php the_time('Y') ; ?></span>
								<span class="mos"><?php the_time('F') ; ?></span>
							</div>
						</div>
						<h3 class="heading mt-2"><a href="<?php the_permalink() ; ?>"><?php the_title() ; ?></a></h3>
						<p><?php echo kama_excerpt( array('maxchar'=>100) ); ?></p>
					</div>
				</div>
			</div>
            <?php endwhile;
            wp_reset_postdata(); // чтобы ничего не поломать
            ?>
        </div>
        <div class="row mt-1">
            <div class="col text-center">
                <div class="block-27">
					<?php
					// пагинация для произвольного запроса
					$big = 999999999; // уникальное число
					echo paginate_links( array(
						'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#middle_blog',
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total'   => $query_blog->max_num_pages,
						'show_all' => true,
						'type' => 'list',
						'prev_next' => true,
						'prev_text' => '&lt;',
						'next_text' => '&gt;',
					) );
					?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();
<section class="ftco-section bg-light">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<span class="subheading">Наш Блог</span>
				<h2>Свежие Статьи</h2>
			</div>
		</div>
		<div class="row d-flex justify-content-around">
			<?php
			if (is_front_page()) {
				$get_posts_simple = get_posts_simple( 3 );
			}
			else $get_posts_simple = get_posts_simple();
            foreach ($get_posts_simple as $post) : ?>
				<div class="col-md-4 d-flex ftco-animate">
					<div class="blog-entry justify-content-end">
						<a href="<?php the_permalink($post->ID); ?>"> 
							<div class="block-20" style="background-image: url(<?php echo get_the_post_thumbnail_url() ;//URL миниатюры ?>); background-size:cover">
							</div>
						</a>
						<div class="text p-4 float-right d-block">
							<div class="topper d-flex align-items-center">
								<div class="one py-2 pl-2 align-self-stretch">
									<span class="day"><?php the_time('d'); ?></span>
								</div>
								<div class="two pl-2 pr-3 py-2 align-self-stretch">
									<span class="yr"><?php the_time('Y'); ?></span>
									<span class="mos"><?php the_time('F'); ?></span>
								</div>
							</div>
							<h3 class="heading mt-2"><a href="<?php the_permalink($post->ID); ?>"><?php echo $post->post_title ; ?></a></h3>
							<p><?php echo kama_excerpt( array('maxchar'=>100) ); ?>
							</p>
						</div>
					</div>
				</div>
			<?php endforeach;
			wp_reset_postdata(); ?>
		</div>
	</div>
</section>
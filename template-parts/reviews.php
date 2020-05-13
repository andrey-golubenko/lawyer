<section class="ftco-section testimony-section bg-secondary">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
				<span class="subheading">Нас Рекомендуют</span>
				<h2 class="mb-4">Наши Партнёры</h2>
			</div>
		</div>
		<div class="row ftco-animate">
			<div class="col-md-12">
				<div class="carousel-testimony owl-carousel ftco-owl">
					<?php foreach(get_post_reviews() as $post ): ?>
						<div class="item">
							<div class="testimony-wrap text-center py-4 pb-5">
								<div class="user-img mb-4" style="background-image: url(<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>); background-size:cover">
									<span class="quote d-flex align-items-center justify-content-center">
									  <i class="icon-quote-left"></i>
									</span>
								</div>
								<div class="text p-3">
									<p class="mb-4"><?php echo esc_attr(get_post_meta( $post->ID, 'description', 1)); ?></p>
									<p class="name"><?php echo $post->post_title; ?></p>
									<span class="position"><?php echo esc_attr(get_post_meta($post->ID, 'kind', 1)); ?></span>
								</div>
							</div>
						</div>
					<?php endforeach;
					wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
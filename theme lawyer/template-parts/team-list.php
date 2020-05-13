<?php if (is_front_page()) : ?>
    <section class="ftco-section bg-secondary">
<?php else: ?>
    <section class="ftco-section bg-light">
<?php endif; ?>
	<div class="container-fluid">
		<div class="row justify-content-center mb-5 pb-3">
			<?php if (is_front_page()) : ?>
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
	        <?php else: ?>
                <div class="col-md-7 text-center heading-section ftco-animate">
	        <?php endif; ?>
                <span class="subheading">Знакомимся . . .</span>
				<h2 class="mb-4">Немного о себе... </h2>
			</div>
		</div>
                <div class="row justify-content-around">
             <?php
                if (is_front_page()) {
                    $get_post_lawyers = get_post_lawyers( 4 );
                }
                else $get_post_lawyers = get_post_lawyers();
                    foreach ( $get_post_lawyers as $post ):
	                    setup_postdata($post);
             ?>
				<div class="col-lg-3 col-sm-6">
					<div class="block-2 ftco-animate">
						<div class="flipper">
							<div class="front" style="background-image: url(<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>); background-size:cover">
								<div class="box">
									<h2><?php echo $post->post_title; ?></h2>
									<p><?php echo esc_attr(get_post_meta( $post->ID, 'specialty', 1));?></p>
								</div>
							</div>
							<div class="back">
								<!-- back content -->
								<blockquote>
									<p>&ldquo; <?php echo esc_attr(get_post_meta( $post->ID, 'description', 1));?> &rdquo;</p>
								</blockquote>
								<div class="author d-flex">
									<div class="image mr-3 align-self-center">
										<img src="<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>" alt="">
									</div>
									<div class="name align-self-center"><?php echo $post->post_title; ?><span class="position"><?php echo esc_attr(get_post_meta( $post->ID, 'specialty', 1));?></span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
                    <?php endforeach; ?>
                      <?php  wp_reset_postdata(); ?>
                    </div>
                </div>
    </section>
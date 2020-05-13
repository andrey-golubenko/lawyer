<section class="ftco-consultation">
	<div class="container-fluid">
		<div class="row d-md-flex">
			<div class="half order-md-last mt-md-0 d-flex justify-content-center align-items-center img" style="background-image: url(<?php echo A_IMG_DIR . '/bg_1.jpg'; ?>); background-size:cover">
				<div class="overlay"></div>
				<div class="desc text-center">
					<div class="icon"><span class="flaticon-auction"></span></div>
					<h2><a href="<?php echo home_url(); ?>"><span class="h1"><?php bloginfo('name'); ?></span><br><span class="small-text">Меня знают многие, доверяют Все</span></a></h2>
				</div>
			</div>
			<div class="half p-3 p-md-5 ftco-animate">
				<h3 class="mb-4 consultation_topic">Бесплатная Консультация</h3>
				<?php echo do_shortcode('[art_feedback]') ?>
			</div>
		</div>
	</div>
</section>

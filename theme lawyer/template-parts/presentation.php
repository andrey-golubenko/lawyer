<section class="ftco-counter" id="section-counter">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 full-width" >
				<div class="front-image img d-flex align-self-stretch align-items-center justify-content-center" style="background-image:url(<?php echo wp_get_attachment_url(get_theme_mod('custom_photo')); ?>); background-size:cover">
					<a href="<?php echo home_url('/') . esc_attr( get_theme_mod('custom_video') ); ?>" class="icon-video simple-ajax-popup d-flex justify-content-center align-items-center">
						<span class="icon-play"></span>
					</a>
				</div>
			</div>
			<div class="col-md-6 px-5 py-5 full-width">
				<div class="row justify-content-start pt-3 pb-3">
					<div class="col-md-12 heading-section ftco-animate">
						<h2 class="mb-4">Моя История . . .</h2>
						<p class="simple-text">Однажды, я принял осознанное решение - получить юридическое образование и стать на защиту прав людей.</p> 

						<p class="simple-text">Исходя из этого я веду свою адвокатскую деятельность. Мое стремление быть лучшим в своем деле мотивирует меня к постоянному совершенствованию знаний, что является гарантией успеха в любом деле.</p>

						<p class="simple-text">Уверенно могу сказать, что каждый обратившийся ко мне за помощью, найдет понимание и юридическую защиту.</p>

						<p class="simple-text">Ведь зная свои права или слабые места в обвинении, можно выйти победителем из любой ситуации.</p>
					</div>
				</div>
				<div class="row">
					<?php if ( (int) (get_theme_mod('custom_lawyers_amount') != '') && (is_numeric( (int) get_theme_mod('custom_lawyers_amount') ) ) ) : ?>
						<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center py-4 bg-light mb-4">
								<div class="text">
									<div class="icon d-flex justify-content-center align-items-center">
										<span class="flaticon-medal"></span>
									</div>
									<strong class="number" data-number="<?php echo (int) get_theme_mod('custom_lawyers_amount'); ?>">0</strong><strong class="number"> %</strong> 
									<span>гарантия конфиденциальности</span>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ( (int) get_theme_mod('custom_trusted_clients') != '') && (is_numeric( (int) get_theme_mod('custom_trusted_clients') ) ) ) : ?>
						<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center py-4 bg-light mb-4">
								<div class="text">
									<div class="icon d-flex justify-content-center align-items-center">
										<span class="flaticon-handshake"></span>
									</div>
									<strong class="number" data-number="<?php echo (int) get_theme_mod('custom_trusted_clients'); ?>">0</strong><strong class="number"> часа</strong>
									<span>в сутки для связи с клиентом</span>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ( (int) get_theme_mod('custom_successful_cases') != '') && (is_numeric( (int) get_theme_mod('custom_successful_cases') ) ) ) : ?>
						<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center py-4 bg-light mb-4">
								<div class="text">
									<div class="icon d-flex justify-content-center align-items-center">
										<span class="ion-ios-checkbox-outline"></span>
									</div>
									<strong class="number" data-number="<?php echo (int) get_theme_mod('custom_successful_cases'); ?>">0</strong><strong class="number"> лет</strong>
									<span>на рынке юридических услуг</span>
								</div>
							</div>
						</div>
					<?php endif; ?>					
						<div class="col-md-6 justify-content-center counter-wrap ftco-animate">
							<div class="block-18 text-center py-4 bg-light mb-4">
								<div class="text">
									<div class="icon d-flex justify-content-center align-items-center">
										<span class="flaticon-lawyer"></span>
									</div>
									<span class="ion-ios-infinite infinite-icon"></span>
									<span>довольных клиентов</span>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
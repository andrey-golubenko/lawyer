<section class="ftco-section-parallax bg-secondary move-to-top">
    <div class="parallax-img d-flex align-items-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                    <h2>Подпишитесь на нашу Рассылку</h2>
                    <p>Раз или два в месяц Мы будем присылать Вам интересные, а для кого-то очень полезные новости.</p>
                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <div id="stay">
                            <form id="add_feedback_small" class="subscribe-form">
                                <div class="form-group d-flex">
                                    <input type="email" name="art_email_small" id="art_email_small" class="required small_art_email form-control" placeholder="Ваш E-Mail" value=""/>
                                    <input type="checkbox" name="art_anticheck_small" id="art_anticheck_small" class="art_anticheck" style="display: none !important;" value="true" checked="checked"/>
                                    <input type="text" name="art_submitted_small" id="art_submitted_small" value="" style="display: none !important;"/>
                                    <input type="submit" id="submit-feedback-small" class="submit px-3" value="Подписаться"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="ftco-footer ftco-bg-dark ftco-section">
	<div class="container">
		<div class="row mb-5">
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2"><?php echo bloginfo('name') ;?></h2>
					<p>Мы здесь, что бы помочь Вам! <br> <br>Обращайтесь и Вы получите самые эффективные решения!</p>
					<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        <?php if ( esc_attr( get_theme_mod('social_twitter') )!= '') : ?>
						<li class="ftco-animate"><a href="<?php echo esc_attr( get_theme_mod('social_twitter') ) ; ?>" target="_blank"><span class="icon-twitter"></span></a></li>
                        <?php endif; ?>
						<?php if ( esc_attr( get_theme_mod('social_facebook') ) != '') : ?>
						<li class="ftco-animate"><a href="<?php echo esc_attr( get_theme_mod('social_facebook') ) ; ?>" target="_blank"><span class="icon-facebook"></span></a></li>
						<?php endif; ?>
						<?php if ( esc_attr( get_theme_mod('social_instagram') ) != '') : ?>
						<li class="ftco-animate"><a href="<?php echo esc_attr( get_theme_mod('social_instagram') ) ; ?>" target="_blank"><span class="icon-instagram"></span></a></li>
						<?php endif; ?>
                    </ul>
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4 ml-md-3">
					<h2 class="ftco-heading-2">Законодательство</h2>
                    <ul class="list-unstyled">
                        <?php
                        $args_cat_foot = array(
	                        'taxonomy' => 'category',
	                        'orderby'    => 'ID',
	                        'order'      => 'ASC',
	                        'hide_empty' => false,
	                        'exclude' => 1,
                        );
                        $categories_foot = get_categories( $args_cat_foot );
                        $count_foot = count($categories_foot);
                        if ( $count_foot > 0 ){
	                        foreach ( $categories_foot as $category_foot ) {
		                        $item_foot = '<li>';
		                        $item_foot .= '<a href="' . get_term_link( $category_foot ) . '" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>' . $category_foot->name . '</a>' ;
		                        $item_foot .= '</li>';
		                        echo $item_foot;
	                        }
                        }
                        ?>
                    </ul>
                </div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Время работы</h2>
					<div class="opening-hours">
						<h4>Дни работы:</h4>
						<p class="pl-3">
							<span>Понедельник – Пятница : <br> с 9.00 до 20.00</span><br>
							<span>Субота : <br> с 9.00 до 17.00</span>
						</p>
						<h4>Выходные:</h4>
						<p class="pl-3">
							<span>Все Воскресные дни</span><br>
							<span>Все Государственные праздники</span>
						</p>
					</div>
				</div>
			</div>
			<div class="col-md">
				<div class="ftco-footer-widget mb-4">
					<h2 class="ftco-heading-2">Спросите ?</h2>
					<div class="block-23 mb-3">
						<ul>
                            <?php if ( esc_attr( get_theme_mod('contacts_address') ) != '') : ?>
							<li><span class="icon icon-map-marker"></span><span class="text"><?php echo esc_attr(   get_theme_mod('contacts_address') ) ; ?></span></li>
                            <?php endif; ?>
							<?php if ( esc_attr( get_theme_mod('contacts_address2') ) != '') : ?>
							<li><span class="icon icon-map-marker"></span><span class="text"><?php echo esc_attr(   get_theme_mod('contacts_address2') ) ; ?></span></li>
                            <?php endif; ?>
                            <?php if ( esc_attr(get_theme_mod('contacts_phone')) != '') : ?>
                            <li><a href="tel://<?php echo esc_attr(get_theme_mod('contacts_phone')) ; ?>"><span class="icon icon-phone"></span><span class="text"><?php echo esc_attr( get_theme_mod('contacts_phone') ) ; ?></span></a></li>
                            <?php endif; ?>
							<?php if ( esc_attr(get_theme_mod('contacts_e-mail')) != '') : ?>
                            <li><a href="mailto:<?php echo esc_attr(get_theme_mod('contacts_e-mail')) ; ?> "><span class="icon icon-envelope"></span><span class="text"><?php echo esc_attr(get_theme_mod('contacts_e-mail')); ?></span></a></li>
                            <?php endif; ?>
                        </ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright  &copy; 2019 - <?php echo date('Y') ?>.   Все права защищены.</p>
                    <p class="template-ancor">This template is made by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
			</div>
		</div>
	</div>
	<div class="arrow-up">
		<img src="<?php echo A_IMG_DIR . '/arrow-up.png'; ?> " alt="image-arrow">
	</div>
</footer>
<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
    </svg>
</div>
<?php wp_footer(); ?>
</body>
</html>
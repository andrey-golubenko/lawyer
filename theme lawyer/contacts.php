<?php
/**
 * Template Name: contacts
 */
?>
<?php get_header('else'); ?>
<section class="ftco-section contact-section">
	<div class="container">
		<div class="row d-flex mb-5 contact-info">
			<div class="col-md-12 mb-4">
				<h2 class="h3" id="contact-link">Контактная Информация</h2>
			</div>
			<div class="w-100"></div>
			<div class="col-md-4">
				<?php if ( esc_attr( get_theme_mod('contacts_address') ) != '') : ?>
				<div><span>Адресс : </span><span class="color-black"><?php echo esc_attr( get_theme_mod ('contacts_address') ) ; ?> ;</span><br><span class="color-black"><?php echo esc_attr( get_theme_mod ('contacts_address2') ) ; ?></span>
				</div>
                <?php endif; ?>
			</div>
			<div class="col-md-4">
				<?php if ( esc_attr( get_theme_mod('contacts_phone') ) != '') : ?>
				<p><span>Телефон : </span> <a href="tel://<?php echo esc_attr( get_theme_mod('contacts_phone') ) ; ?>"><?php echo esc_attr( get_theme_mod('contacts_phone') ) ; ?></a></p>
                <?php endif; ?>
			</div>
			<div class="col-md-4">
                <?php if ( esc_attr( get_theme_mod('contacts_e-mail') ) != '' ) : ?>
				<p><span>Email : </span> <a href="mailto:<?php echo esc_attr( get_theme_mod('contacts_e-mail') ) ; ?>"><?php echo esc_attr( get_theme_mod('contacts_e-mail') ) ; ?></a></p>
                <?php endif; ?>
			</div>
		</div>
		<div class="row block-9">
			<div class="col-lg-6 order-md-last d-flex mb-3">
                <div class="contact-form p-5 bg-light">
                    <?php echo do_shortcode('[art_feedback]') ; ?>
                </div>
			</div>
            <div class="col-lg-6 d-flex mb-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1210.557625719427!2d36.25449170253844!3d49.99106694396302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4127a09384090bf5%3A0x5dcfb83e2d9f467e!2zNEEsINGD0LsuINCu0YDRjNC10LLRgdC60LDRjywgNNCQLCDQpdCw0YDRjNC60L7Qsiwg0KXQsNGA0YzQutC-0LLRgdC60LDRjyDQvtCx0LvQsNGB0YLRjCwgNjEwMDA!5e0!3m2!1sru!2sua!4v1587829541570!5m2!1sru!2sua" width="600" height="700" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
				<!--<div id="map" class="bg-white"></div>-->
			</div>
		</div>
	</div>
</section>
<?php get_footer();
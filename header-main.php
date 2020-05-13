<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head();?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light oyt_border" id="ftco-navbar">
    <div class="container">
		<?php if( !empty(get_theme_mod ('custom_logo') || get_theme_mod ('custom_logo2') ) ) : ?>
        <div class="logo-lawyer">			
            <a href="<?php echo home_url(); ?>">
 				<div class="logo-lawyer-image">
                    <img class="logo-lawyer-image-light" src="<?php echo get_theme_mod ('custom_logo'); ?>" alt = "">
                    <img class="logo-lawyer-image-black" src="<?php echo get_theme_mod ('custom_logo2'); ?>" alt = "">
                </div>				
                <div class="logo-text">
                    <h1 class="navbar-brand"><?php bloginfo('name'); ?></h1>
                </div>
            </a>
        </div>
		<?php else : ?>
		    <a href="<?php echo home_url(); ?>">
                <div class="logo-text">
                    <h1 class="navbar-brand"><?php bloginfo('name'); ?></h1>
                </div>
            </a>	
		<?php endif; ?>		
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> МЕНЮ
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <?php wp_nav_menu([
                'theme_location'  => 'top',
                'container'       => false,
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'menu_class'      => 'navbar-nav ml-auto',
                'depth'           => 1,
            ])
            ?>
        </div>
    </div>
</nav>
<!-- END nav -->
<div class="hero-wrap js-fullheight move-to-top" style="background-image: url(<?php echo A_IMG_DIR . '/bg_1.jpg';?>); background-size:cover" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
			<div class="big-head-text col-md-10 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
				<h2 class="subheading" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" style="opacity: 0.522568; transform: translateZ(0px) translateY(-8.95184%);" >Мы здесь, чтобы помочь!</h2>
				<h2 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
					<span>Опыт</span>. <span>Квалификация</span>. <span>Оперативность</span>.
				</h2>
				<p><a href=" <?php echo get_page_link(17); ?> " class="btn btn-primary py-3 px-4">Получить профессиональную консультацию</a></p>
			</div>
		</div>
	</div>
</div>
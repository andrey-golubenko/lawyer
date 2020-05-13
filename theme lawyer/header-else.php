<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head();?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
		<?php if( !empty(get_theme_mod ('custom_logo') || get_theme_mod ('custom_logo2') ) ) : ?>
        <div class="logo-lawyer">			
            <a href="<?php echo home_url(); ?>">
 				<div class="logo-lawyer-image">
                    <img class="logo-lawyer-image-light" src="<?php echo get_theme_mod ('custom_logo'); ?>" alt = "image">
                    <img class="logo-lawyer-image-black" src="<?php echo get_theme_mod ('custom_logo2'); ?>" alt = "image">
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
<?php
if( is_archive() ){
	get_template_part('template-parts/breadcrumbs-archive');
}
else get_template_part('template-parts/breadcrumbs');
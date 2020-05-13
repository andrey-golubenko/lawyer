<?php $URIreq = $_SERVER['REQUEST_URI'];
if ( preg_match('/\.(jpg|jpeg|gif|png|zip)(\?.+)?$/', $URIreq ) ){

	$PathToFileFromRoot = $_SERVER['DOCUMENT_ROOT'].$URIreq;
	$PathToFileFromRoot = str_replace( '//', '/', $PathToFileFromRoot );
	if ( !file_exists($PathToFileFromRoot) ){
		echo "<div style='margin:100px 10% 0 10%; padding:20px; text-align:center; border:1px solid #42A6FF; background:#DEF0FF; white-space:nowrap;'>
		<b>File not found:</b> $URIreq<br>
		<b>From Page:</b> <a href='{$_SERVER["HTTP_REFERER"]}'>{$_SERVER["HTTP_REFERER"]}</a><br>
		<div style='font-size:25px; padding-top:30px;'>Go to WebSite: <a href='http://{$_SERVER['HTTP_HOST']}'>http://{$_SERVER['HTTP_HOST']}</a></div>
		</div>";
		exit();
	}
}
get_header('main');?>
<!--SERVICES section-->
<?php
    get_template_part('template-parts/services');
?>
<!--PRESENTATION section-->
<?php
    get_template_part('template-parts/presentation');
?>
<!--CATEGORIES section -->
<section class="ftco-section bg-light">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 text-center heading-section ftco-animate">
				<span class="subheading">Мы можем в этом помочь . . .</span>
				<h2 class="mb-4">Сферы Деятельности</h2>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<?php
            $args_cat_front = array(
				'taxonomy' => 'category',
				'order'      => 'ASC',
				'hide_empty' => false,
                'exclude' => 1,
			);
			$categories_front = get_categories( $args_cat_front );
			$count_front = count($categories_front);
			if ( $count_front > 0 ){
				foreach ( $categories_front as $category_front ) {
					$item_front = '<div class="col-md-4 text-center practice-item-front">';
					$item_front .= '<div class="practice-area ftco-animate">';
					$item_front .= '<div class="icon category-slug-' . $category_front->slug . ' d-flex justify-content-center align-items-center">';
					$item_front .= '<span></span>';
					$item_front .= '</div>';
					$item_front .= '<h3>';
					$item_front .= '<a href="' . get_term_link( $category_front ) . '">' . $category_front->name . '</a>' ;
					$item_front .= '</h3>';
					$item_front .= '</div>';
					$item_front .= '</div>';
					echo $item_front;
				}
			}
			?>
		</div>
	</div>
</section>
<!-- TEAM section -->
<?php //Показываем секцию 'team', ТОЛЬКО если есть ХОТЬ ОДНА запись о членах команды.
    if ( !empty(get_post_lawyers())):
        get_template_part('template-parts/team-list');
endif; ?>
<!--FEEDBACK section-->
<section class="ftco-consultation">
	<div class="container-fluid">
		<div class="row d-md-flex">
            <div class="half d-flex justify-content-center align-items-center img" style="background-image: url(<?php echo A_IMG_DIR . '/bg_1.jpg'; ?>); background-size:cover">
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
<!-- REVIEWS section -->
<?php //Показываем секцию 'reviews', ТОЛЬКО если есть ХОТЬ ОДНА запись о клиентах.
    if (!empty(get_post_reviews())) :
        get_template_part('template-parts/reviews');
    endif;
?>
<!-- BLOG section -->
<?php //Показываем секцию 'blog', ТОЛЬКО если есть ХОТЬ ОДНА запись в стандартных posts.
if (!empty(get_posts_simple())) :
    get_template_part('template-parts/posts-list');
endif; ?>
<!-- GALLERY section -->
<?php //Показываем секцию 'gallery', ТОЛЬКО если есть ХОТЬ ОДНА запись в стандартных posts.
if (!empty(get_posts_simple())) : ?>
    <section class="ftco-gallery">
        <div class="container-wrap">
            <div class="row no-gutters">
                <?php foreach (get_posts_simple(4) as $post) : ?>
                <div class="col-md-3 ftco-animate" style="background-image: url(<?php echo get_the_post_thumbnail_url(); //URL Минифтюры ?>); background-size:cover">
                    <a href="<?php echo get_the_post_thumbnail_url(); //URL Минифтюры ?>" class="gallery image-popup img d-flex align-items-center">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php get_footer();
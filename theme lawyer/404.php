<?php
/**
 * The template for displaying 404 pages (not found)
 */
get_header('else');
?>
	<div id="primary" class="content-area mb-5">
		<main id="main" class="site-main">
			<div class="error-404 not-found ">
                <div class="image-404-wrap mt-5">
                    <img class="" src="<?php echo A_IMG_DIR . '/error-404.png' ; ?>" alt="image">
                </div>
                    <h3 class="mb-5 mt-5 text-center">Вы могли здесь оказаться по нескольким причинам:</h3>
					<h5 class="ml-5">1. Страница, которую вы ищите, была перенесена или переименована.</h5>
			
					<h5 class="ml-5">2. Скорее всего URL был вписан с ошибкой.</h5>

					<h5 class="ml-5">3. Такой страницы больше нет (удалена).</h5>
					
                    <h4 class="mb-5 mt-5 text-center">Попробуйте воспользоваться формой поиска, расположенной ниже.</h4>
                    <div class="d-flex justify-content-center pb-5"><?php get_search_form(); ?></div>
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer();
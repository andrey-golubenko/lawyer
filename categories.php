<?php
/**
 * Template Name: categories
 */
?>
<?php get_header('else'); ?>

<section class="ftco-section bg-light">
	<div class="container">
		<div class="row d-flex justify-content-center" id="middle_cat">
			<?php
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1; //Определяем текущую страницу
			$exclude_cat = 1; //Определяем какую рубрику не выводить (по id)
            $count_terms = wp_count_terms( 'category',
                           array(
                           'hide_empty' => 0,
	                       'exclude' => $exclude_cat
                           ) ); //Получаем общее количество выводимы рубрик
            //Определяем как динамически добавлять offset в аргументы get_categories($args).
			for ($i = 1; $i < $paged; $i++){
				$offset_cat += 4;
			}//То есть, при изменении на 1 значения текущей страницы ($current_page_cat) во время пагинации, увеличиваем на 4 значение offset для соответствующего аргумента get_categories($args).
			$offset_cat = ($paged == 1) ? 0 : $offset_cat; //$offset, который после двоеточия берёт динамическое значение из вышеприведённого цикла.
			$args_cat = array(
				'taxonomy'   => 'category',
				'exclude'    => $exclude_cat,
                'offset'     => $offset_cat,
                'number'     => 8,
				'order'      => 'ASC',
				'hide_empty' => false,
			);
			$categories_cat = get_categories($args_cat);
			if ( $count_terms > 0 ){
				foreach ( $categories_cat as $category_cat ) {
					$item_cat = '<div class="col-md-4 col-lg-3 text-center">';
					$item_cat .= '<div class="practice-area bg-white ftco-animate p-4">';
					$item_cat .= '<div class="icon category-slug-' . $category_cat->slug . ' d-flex justify-content-center align-items-center">';
					$item_cat .= '<span></span>';
					$item_cat .= '</div>';
					$item_cat .= '<h3 class="mb-3">';
					$item_cat .= '<a href="' . get_term_link( $category_cat ) . '">' . $category_cat->name . '</a>' ;
					$item_cat .= '</h3>';
					$item_cat .= '<p class="cat-dicription">' . $category_cat->category_description . '</p>';
					$item_cat .= '</div>';
					$item_cat .= '</div>';
					echo $item_cat;
				}
			}
			?>
		</div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
					<?php
					$big = 999999999; // уникальное число
					echo paginate_links( array(
						'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => ceil($count_terms/8), //Количество страниц для пагинации получаем путём округления в большую сторону результата деления общего количества выводимых категорий на количество категорий отображаемых на одной странице.
						'show_all' => true,
						'type' => 'list',
						'prev_next' => true,
						'prev_text' => '&lt;',
						'next_text' => '&gt;',
					) );
					?>
                </div>
            </div>
        </div>
	</div>
</section>

<!--FEEDBACK section-->
<?php
    get_template_part('template-parts/consultation-else');
get_footer();
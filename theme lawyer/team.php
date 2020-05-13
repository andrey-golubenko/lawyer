<?php
/**
 * Template Name: team
 */
?>
<?php get_header('else'); ?>
<section class="ftco-section bg-light">
    <div class="container-fluid">
        <div class="row justify-content-center pb-2">
            <div class="col-md-7 text-center heading-section ftco-animate" >
                <span class="subheading">Знакомимся ...</span>
                <h2 class="mb-4" id="middle_team">Наша Команда</h2>
            </div>
        </div>
        <div class="row justify-content-around">
                <?php
                // определяем текущую страницу из значения параметра "comanda"
                $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                // обычный WP_Query
                $query_team = new WP_Query( array(
                    'paged' 	  	 => $paged, // передаём текущую страницу сюда!
                    'post_type'   	 => 'team',
                    'posts_per_page' => 4,
                    'order'		 	 => 'ASC',
                ) );
                while( $query_team->have_posts() ) : $query_team->the_post();
                ?>
                <div class="col-lg-3 col-sm-6">
                        <div class="block-2 ftco-animate">
                            <div class="flipper">
                                <div class="front" style="background-image: url(<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>); background-size:cover">
                                    <div class="box">
                                        <h2><?php echo $post->post_title; ?></h2>
                                        <p><?php echo esc_attr(get_post_meta( $post->ID, 'specialty', 1)); ?></p>
                                    </div>
                                </div>
                                <div class="back">
                                    <!-- back content -->
                                    <blockquote>
                                        <p>&ldquo; <?php echo esc_attr( get_post_meta( $post->ID, 'description', 1)); ?> &rdquo;</p>
                                    </blockquote>
                                    <div class="author d-flex">
                                        <div class="image mr-3 align-self-center">
                                            <img src="<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>" alt="">
                                        </div>
                                        <div class="name align-self-center"><?php echo $post->post_title; ?><span class="position"><?php echo esc_attr( get_post_meta( $post->ID, 'specialty', 1)); ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                      wp_reset_postdata(); // Сбрасываем $post
                ?>
            </div>
        <div class="row mt-1">
            <div class="col text-center">
                <div class="block-27">
                    <?php
                        // пагинация для произвольного запроса
                        $big = 999999999; // уникальное число
                        echo paginate_links( array(
                            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#middle_team',
                            'format'    => '?paged=%#%',
                            'current'   => max( 1, get_query_var('paged') ),
                            'total'     => $query_team->max_num_pages,
                            'show_all'  => true,
                            'type'      => 'list',
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
<?php get_footer();
<?php get_header('else') ; ?>
<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-md-last ftco-animate">
                <?php while (have_posts()) : the_post(); ?>
                <div class="mb-1">
                    <a href="<?php the_permalink() ; ?>">
                        <p><img src="<?php echo get_the_post_thumbnail_url() ; ?>" alt="image" class="img-fluid image-archive"></p>
                    </a>
                    <a href="<?php the_permalink() ; ?>">
                        <h2 class="mb-3"><?php the_title() ; ?></h2>
                    </a>
                    <p><?php echo kama_excerpt( array('maxchar'=>110) ); ?></p>
                    <div class="tag-widget post-tag-container mb-3 mt-3">
                        <div class="tagcloud">
                            <?php $post_tags = get_the_tags();
                            if( $post_tags ){
                                foreach( $post_tags as $tag ){
                                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-cloud-link">' . $tag->name . '</a>';
                                }
                            } ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                <div class="row mt-1">
                    <div class="col text-center">
                        <div class="block-27">
				            <?php the_posts_pagination(array(
					            'show_all' => true,
					            'type' => 'list',
					            'prev_next' => true,
					            'prev_text' => '&lt;',
					            'next_text' => '&gt;',
				            ) ) ; ?>
                        </div>
                    </div>
                </div>
                <h2 class="mb-3 mt-5">Мы можем в этом помочь !</h2>
                <p>Многих адвокатов называют ценичными и безжалостными акулами. Для нас защита клиента всегда будет приоритетной задачей. Размер гонорара будет учитывать материальное состояние клиента и СОИЗМЕРИМ с ожидаемым результатом от выигранного дела. Ваша вера в успех дела будет обязательно подкреплена опытом и квалификацией наших сотрудников.</p>
                <p><a href=" <?php echo get_page_link(17); ?> " class="btn btn-primary">Получить Профессиональную Консультацию</a></p>

                <?php //Показываем секцию 'team', ТОЛЬКО если есть ХОТЬ ОДНА запись о членах команды.
                if ( !empty(get_post_lawyers())): ?>
                    <div class="row justify-content-around mt-5">
                        <?php
                        $get_post_lawyers = get_post_lawyers( 2);
                        foreach ( $get_post_lawyers as $post ):
                            setup_postdata($post); ?>
                            <div class=" col-sm-6">
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
                                                <p>&ldquo; <?php echo esc_attr(get_post_meta( $post->ID, 'description', 1)); ?> &rdquo;</p>
                                            </blockquote>
                                            <div class="author d-flex">
                                                <div class="image mr-3 align-self-center">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); //URL миниатюры?>" alt="">
                                                </div>
                                                <div class="name align-self-center"><?php echo $post->post_title; ?><span class="position"><?php echo esc_attr(get_post_meta( $post->ID, 'specialty', 1)); ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php  wp_reset_postdata(); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div> <!-- .col-md-8 -->
            <?php get_sidebar() ; ?>
        </div>
    </div>
</section>
<?php get_footer();
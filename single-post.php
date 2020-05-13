<?php get_header('else');?>
<section class="ftco-section ftco-degree-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-md-last ftco-animate">
				<p>
					<img src="<?php echo get_the_post_thumbnail_url() ; ?>" alt="" class="img-fluid">
				</p>
				<h2 class="mb-3"><?php the_title() ; ?></h2>
                <?php the_post() ; ?>
				<div class="color-black">
					<div id="move_to_popup" >
					<?php the_content() ; ?>
					</div>
				</div>				
				<?php wp_reset_postdata() ; ?>
				<div class="tag-widget post-tag-container mb-5 mt-5">
					<div class="tagcloud">
						<?php $post_tags = get_the_tags();
						      if( $post_tags ){
							        foreach( $post_tags as $tag ){
								    echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-cloud-link">' . $tag->name . '</a>';
							        }
						      } ?>
					</div>
				</div>
				<div class="about-author d-flex p-4 bg-light mb-4">
					<div class="desc">
						<h3>Автор Статьи : <?php the_author(); ?></h3>
					</div>
				</div>
                <?php if (get_comments_number() >= 7) : ?>
                <button type="button" id="comment-ancor" class="btn btn-primary mb-4">
                	Оставить комментарий
            	</button>
                <?php endif; ?>
                <?php if(comments_open() || get_comments_number()){
                        comments_template(); } ?>
			</div> <!-- .col-md-8 -->
            <?php get_sidebar() ; ?>
		</div>
	</div>
</section>
<?php get_footer();
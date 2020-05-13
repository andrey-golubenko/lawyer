<div class="col-md-4 d-flex ftco-animate">
	<div class="blog-entry justify-content-end">
		<a href="<?php the_permalink() ; ?>" class="block-20" style="background-image: url(<?php echo get_the_post_thumbnail_url() ; ?>); background-size:cover">
		</a>
		<div class="text p-4 float-right d-block">
			<div class="topper d-flex align-items-center">
				<div class="one py-2 pl-2 align-self-stretch">
					<span class="day"><?php the_time('d') ; ?></span>
				</div>
				<div class="two pl-2 pr-3 py-2 align-self-stretch">
					<span class="yr"><?php the_time('Y') ; ?></span>
					<span class="mos"><?php the_time('F') ; ?></span>
				</div>
			</div>
			<h3 class="heading mt-2"><a href="<?php the_permalink() ; ?>"><?php the_title() ; ?></a></h3>
			<p><?php echo kama_excerpt( array('maxchar'=>500) ) ; ?></p>
		</div>
	</div>
</div>
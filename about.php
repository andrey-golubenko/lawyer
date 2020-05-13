<?php
/**
* Template Name: about
*/
?>

<?php get_header('else'); ?>

<!--PRESENTATION section-->
<?php
    get_template_part('template-parts/presentation');
?>

<!--SERVICES section-->
<section class="ftco-section services-section bg-light">
	<div class="container mt-0">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 text-center heading-section ftco-animate">
				<h2 class="mb-4">Мы предоставляем юридическую помощь</h2>
			</div>
		</div>
        <div class="row no-gutters d-flex">
            <div class="col-md-3 text-center services align-self-stretch ftco-animate p-4">
                <div class="icon"><span class="flaticon-auction"></span></div>
                <div class="media-body">
                    <h3 class="heading mb-3">Защита в судах Любых юрисдикций</h3>
                    <!-- <p>Some Description</p>-->
                </div>
            </div>
            <div class="col-md-3 text-center services align-self-stretch ftco-animate p-4">
                <div class="icon"><span class="flaticon-lawyer"></span></div>
                <div class="media-body">
                    <h3 class="heading mb-3">Индивидуальный подход к каждому клиенту</h3>
                    <!-- <p>Some Description</p>-->
                </div>
            </div>
            <div class="col-md-3 text-center services align-self-stretch ftco-animate p-4">
                <div class="icon"><span class="flaticon-money"></span></div>
                <div class="media-body">
                    <h3 class="heading mb-3">Бонусы и Дисконты постоянным клиентам</h3>
                    <!-- <p>Some Description</p>-->
                </div>
            </div>
            <div class="col-md-3 text-center services align-self-stretch ftco-animate p-4">
                <div class="icon"><span class="ion-ios-help-circle-outline"></span></div>
                <div class="media-body">
                    <h3 class="heading mb-3">Разрешение нестандартных ситуаций</h3>
                    <!-- <p>Some Description</p>-->
                </div>
            </div>
        </div>
    </div>
</section>

<!--FEEDBACK section-->
<?php
    get_template_part('template-parts/consultation-else');
?>
<!-- REVIEWS section -->
<?php //Показываем секцию 'reviews', ТОЛЬКО если есть ХОТЬ ОДНА запись о клиентах.
if (!empty(get_post_reviews())) :
	get_template_part('template-parts/reviews');
endif;
?>
<?php get_footer();
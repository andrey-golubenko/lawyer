(function($) {

	"use strict";

	$(window).stellar({
    responsive: true,
    parallaxBackgrounds: true,
    parallaxElements: true,
    horizontalScrolling: false,
    hideDistantElements: false,
    scrollProperty: 'scroll'
  });


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() {
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
   $.Scrollax();

	var carousel = function() {
		$('.carousel-testimony').owlCarousel({
			center: true,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 2
				},
				1000:{
					items: 3
				}
			}
		});


	};
	carousel();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  console.log('show');
	});

	// scroll
	var scrollWindow = function() {
		$(window).scroll(function(){
			var $w = $(this),
					st = $w.scrollTop(),
					navbar = $('.ftco_navbar'),
					sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');
				}
			}
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			}
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');
				}

				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	var counter = function() {

		$('#section-counter, .hero-wrap, .ftco-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',');
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 7000
					);
				});
			}
		} , { offset: '95%' } );
	};
	counter();


	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function() {
		$(".smoothscroll[href^='#'], #ftco-nav ul li a[href^='#']").on('click', function(e) {
		 	e.preventDefault();

		 	var hash = this.hash,
		 			navToggler = $('.navbar-toggler');
		 	$('html, body').animate({
		    scrollTop: $(hash).offset().top
		  }, 700, 'easeInOutExpo', function(){
		    window.location.hash = hash;
		  });
		  if ( navToggler.is(':visible') ) {
		  	navToggler.click();
		  }
		});
		$('body').on('activate.bs.scrollspy', function () {
		  console.log('nice');
		})
	};
	OnePageNav();


	// magnific popup
	// Тип IMAGE - загрузка картинок в модальном окне
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: false,
      duration: 300 // don't forget to change the duration also in CSS
    }
  });

// Тип Ajax - загрузка "типа" любого контента в модальном окне
	$('.simple-ajax-popup').magnificPopup({
		type: 'ajax',
		callbacks: {
			parseAjax: function(mfpResponse) {
				 mfpResponse.data = $(mfpResponse.data).find('#move_to_popup');
				console.log('Ajax content loaded:', mfpResponse);
			},
		}
	});


// КОНТАКТНАЯ Форма БОЛЬШАЯ
jQuery(document).ready(function ($) {

	const add_form = $("#add_feedback");

	// Сброс значений полей
	$('#add_feedback input, #add_feedback textarea').on('blur', function () {
		$('#add_feedback input, #add_feedback textarea').removeClass('error');
		$('.error-name,.error-email,.error-comments,.message-success').remove();
		$('#submit-feedback').val('Отправить сообщение');
	});


	// Отправка значений полей
	const options = {
		url: feedback_object.ajaxurl, //Ссылка на свойство (ajaxurl) объекта feedback_object.ajaxurl, указанное в wp_localize_script в файле function.php
		data: {
			action: 'feedback_action', // Берётся из вторых частей названий экшинов wp_ajax_feedback_action и wp_ajax_nopriv_feedback_action в файле function.php
			nonce: feedback_object.nonce
			},
		type: 'POST',
		dataType: 'json',

		beforeSubmit: function (xhr) {
			// При отправке формы меняем надпись на кнопке
			$('#submit-feedback').val('Отправляем...');
		},
		success: function (request, xhr, status, error) {

			// Если все поля заполнены, отправляем данные и меняем надпись на кнопке
		    if (request.success === true) {
				add_form.after('<div class="message-success">' + request.data + '</div>').slideDown();
				$('#submit-feedback').val('Отправить сообщение');
				// При успешной отправке сбрасываем значения полей
				$('#add_feedback')[0].reset();
			}
		    else {
				// Если поля не заполнены, выводим сообщения и меняем надпись на кнопке
				$.each(request.data, function (key, val) {
					// noinspection JSJQueryEfficiency
					$('.art_' + key).addClass('error');
					// noinspection JSJQueryEfficiency
					$('.art_' + key).before('<span class="error-' + key + '">' + val + '</span>');
				});
				$('#submit-feedback').val('Что-то пошло не так...');
			}
		},
		error: function (request, status, error) {
			$('#submit-feedback').val('Что-то пошло не так...');
		}
	};
	// Отправка формы
	add_form.ajaxForm(options);
});

// КОНТАКТНАЯ Форма МАЛАЯ
jQuery(document).ready(function ($) {
	const add_form_small = $("#add_feedback_small");

	// Сброс значений полей
	$('#add_feedback_small input').on('blur', function () {
		$('#add_feedback_small input').removeClass('small-error');
		$('.small-error-email').remove();
		$('#submit-feedback-small').val('Подписаться');
	});

	// Отправка значений полей
	const options_small = {
		url: feedback_object.ajaxurl, //Ссылка на свойство (ajaxurl) объекта feedback_object.ajaxurl, указанное в wp_localize_script в файле function.php
		data: {
			action: 'feedback_action_small', // Берётся из вторых частей названий экшинов wp_ajax_feedback_action и wp_ajax_nopriv_feedback_action в файле function.php
			nonce: feedback_object.nonce
		},
		type: 'POST',
		dataType: 'json',
		success: function (request, xhr, status, error) {
			// Если все поля заполнены, отправляем данные и меняем надпись на кнопке
			if (request.success === true) {
				add_form_small[0].reset();
				add_form_small.slideUp(500);
				setTimeout(()=> $('#stay').after('<div class="message-success-small">' + request.data + '</div>').fadeIn( "slow" ), 500)
			}
			else {
				// Если поля не заполнены, выводим сообщения и меняем надпись на кнопке
				$.each(request.data, function (key, val) {
					$('.small_art_' + key).addClass('small-error');
					$('.small_art_' + key).before('<span class="small-error-' + key + '">' + val + '</span>');
				});
				$('#submit-feedback-small').val('Что-то пошло не так...');
			}
		},
		error: function (request, status, error) {
			$('#submit-feedback-small').val('Что-то пошло не так...');
		}
	};
	// Отправка формы
	add_form_small.ajaxForm(options_small);
});

//ПОДТЯГИВАЕМ Форму Комментариев К КОНЦУ ПОСТА
$('#comment-ancor').click(function() {
	$('#comment-ancor').after( $('#respond') );
	return false;
});

// СТРЕЛКА "НАВЕРХ" (arrow-up)
$(window).scroll(function () {
    if ($(this).scrollTop() > 500) {
        $('.arrow-up').fadeIn();
      }
    else {
        $('.arrow-up').fadeOut();
      }
  });
$('.arrow-up').click(function () {
    $('body,html').animate({scrollTop: 0}, 1000);
    return false;}
);



})(jQuery);


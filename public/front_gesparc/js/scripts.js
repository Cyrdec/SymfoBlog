(function($) {
    'use strict';

    jQuery(document).ready(function() {

		/*PRELOADER JS*/
		$(window).load(function() { 
			$('.spinner').fadeOut();
			$('.preloader').delay(350).fadeOut('slow'); 
		}); 
		/*END PRELOADER JS*/
			
		/* START MENU JS */
			$('.navbar-fixed-top a').on('click', function(e){
				var anchor = $(this);
				$('html, body').stop().animate({
					scrollTop: $(anchor.attr('href')).offset().top - 50
				}, 1500);
				e.preventDefault();
			});		

			/*	Mobile Menu
			------------------------*/
			jQuery('#navigation').meanmenu({
				meanScreenWidth: "767",
				meanMenuContainer: ".menu_wrap",				
			});
				
			$(window).scroll(function() {
			  if ($(this).scrollTop() >0) {
				$('.menu-top').addClass('menu-shrink');
			  } else {
				$('.menu-top').removeClass('menu-shrink');
			  }
			});
			
			$(document).on('click','.navbar-collapse.in',function(e) {
			if( $(e.target).is('a') && $(e.target).attr('class') != 'dropdown-toggle' ) {
				$(this).collapse('hide');
			}
			});				
		/* END MENU JS */
			
		// Main slider
		
		$('.slider_active').owlCarousel({			
			smartSpeed:650,
			navText:['<i class="ti-arrow-left "></i>','<i class="ti-arrow-right"></i>'],
			autoplay:true,
			autoplayTimeout:20000,
			mouseDrag:true,
			loop: true,
			nav: true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})	

		
			

		/* START APP-SCREENS */		
		
		$('.app_screens_slider').slick({
			slidesToShow: 4,
			slidesToScroll: 4,
			centerPadding: '0px',
			autoplay: false,
			dots: false,
			autoplaySpeed: 5000,		
			responsive: [
				{
				breakpoint: 991,
					settings: {
						slidesToShow: 3,
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 1,
					}
				}
			]
		});		
		/* START APP-SCREENS */

		// Vide Section
		$("#video").simplePlayer();
			
		// Review slider
		$('.review_slider').owlCarousel({			
			smartSpeed:650,
			navText:['<i class="ti-arrow-left "></i>','<i class="ti-arrow-right"></i>'],
			autoplay:true,
			autoplayTimeout:10000,
			mouseDrag:true,
			loop: true,
			nav: true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				1000:{
					items:3
				}
			}
		})	
		
	
    });
})(jQuery);
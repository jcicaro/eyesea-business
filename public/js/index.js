(function($) {
	
	console.log('WPGLOBAL', WPGLOBAL);
	
	// jQuery code
	$(document).ready(function() {
		
		// Style the alert
		$('#message').addClass('alert').addClass('alert-primary');
		
		// Style the table pagination
		$(".pagination .page-item .page-numbers").addClass("page-link");
    	$(".pagination .page-item .page-link").removeClass("page-numbers");
		$(".pagination .page-item .current").parent().addClass("active");
		
		
		// AOS
		$(function() {
		// AOS.init();
			AOS.init({ disable: 'mobile' });
		});
		$(window).on('load', function() {
			AOS.refresh();
		});
		
		// ekko-lightbox
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({
				alwaysShowClose: true
			});
		});
		
		
		// Add classes on sm screen size
		
// 		var wmmSm = window.matchMedia("(max-width: 768px)")
// 		wmmSm.addListener(function(wmmSm) {
// 			var additionalClasses = {
// 				card: 'card',
// 				cardImg: 'card-img',
// 				cardImgOverlay: 'card-img-overlay d-flex flex-column justify-content-end bg-light bg-50'
// 			};
			
// 			if (wmmSm.matches) {
// 				$('.home-item').addClass(additionalClasses.card);
// 				$('.home-item-img-container').addClass(additionalClasses.cardImg);
// 				$('.home-item-txt-container').addClass(additionalClasses.cardImgOverlay);
// 				$('.home-item').removeClass('bg-black');
// 			}
// 			else {
// 				$('.home-item').removeClass(additionalClasses.card);
// 				$('.home-item-img-container').removeClass(additionalClasses.cardImg);
// 				$('.home-item-txt-container').removeClass(additionalClasses.cardImgOverlay);
// 				$('.home-item').addClass('bg-black');
// 			}
			
// 		});
		
		
	});
	
	
})(jQuery);
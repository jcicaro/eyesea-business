(function($) {
	
	console.log('WPGLOBAL', WPGLOBAL);
	
	var defaultAnimationTime = 300;
	
	$(document).ready(function() {
		
// 		if (!WPGLOBAL.IS_SINGLE) {
// 			$('.create-form').hide(defaultAnimationTime);
// 		}
		
// 		$('#toggle-form').click(function() {
// 			$('.create-form').toggle(defaultAnimationTime);
// 		});
		
		$('#message').addClass('alert').addClass('alert-primary');
		
		// Style the table pagination
		$(".pagination .page-item .page-numbers").addClass("page-link");
    	$(".pagination .page-item .page-link").removeClass("page-numbers");
		$(".pagination .page-item .current").parent().addClass("active");
		
	});
})(jQuery);
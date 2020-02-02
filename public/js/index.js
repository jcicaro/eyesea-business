(function($) {
	
	console.log('WPGLOBAL', WPGLOBAL);
	
	var defaultAnimationTime = 300;
	
	$(document).ready(function() {
		
		if (!WPGLOBAL.IS_SINGLE) {
			$('.create-form').hide(defaultAnimationTime);
		}
		
		
		$('#toggle-form').click(function() {
			$('.create-form').toggle(defaultAnimationTime);
		});
		
	});
})(jQuery);
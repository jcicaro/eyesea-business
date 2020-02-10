<?php
	
require_once(get_template_directory() . '/server-includes/ess_custom_post_types.php');

require_once(get_template_directory() . '/server-includes/ess_classes.php');

require_once(get_template_directory() . '/server-includes/ess_rest.php');

require_once(get_template_directory() . '/server-includes/ess_fixes.php');

require_once(get_template_directory() . '/server-includes/ess_components.php');



add_action('wp_enqueue_scripts', function() {

	wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/client-dependencies/font-awesome-4.7.0/css/font-awesome.min.css', array());
	wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/client-dependencies/bootstrap-4.0.0-dist/css/bootstrap.min.css', array());
	
	wp_enqueue_style('Contact-Form-Clean-css', get_template_directory_uri() . '/public/css/vendor/contact-form-clean.css', array());
	
	wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css', array());
    wp_enqueue_style('aos-css', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css', array());
	
	// Lightbox Gallery
	wp_enqueue_style('ekko-lightbox-css', 'https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css', array());
	
	wp_enqueue_style('main', get_template_directory_uri() . '/public/css/main.css', false, rand(1, 100), 'all');

});


add_action('wp_enqueue_scripts', function() {
	$show_in_footer = true; // set this to true later, need wp_footer() in footer.php

	wp_enqueue_script('popper', get_template_directory_uri() . '/client-dependencies/popper/popper.min.js', array(), '1.14.6', $show_in_footer);
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/client-dependencies/bootstrap-4.0.0-dist/js/bootstrap.min.js', array('jquery'), '4.0.0', $show_in_footer);
//         wp_enqueue_script('angular1', get_template_directory_uri() . '/client-dependencies/angular-1.7.7/angular.min.js', array(), '1.7.7', $show_in_footer);
	
	wp_enqueue_script('smart-forms', get_template_directory_uri() . '/public/js/vendor/smart-forms.min.js', array(), '1.0', $show_in_footer);
	
	wp_enqueue_script('aos-js', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js', array(), '2.2.0', $show_in_footer);
	
	// Lightbox Gallery
	wp_enqueue_script('ekko-lightbox-js', 'https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js', array(), '5.3.0', $show_in_footer);
	
	wp_enqueue_script('script', get_template_directory_uri() . '/public/js/index.js', array(), rand(1, 100), $show_in_footer);
});










<?php

// ========================================== 
// ACTIONS
// ========================================== 

// priority is required for this to work, otherwise there will be an error on submit
add_action( 'wp_head', function() { acf_form_head(); }, 2); 


add_action('acf/save_post', ['ESS_Post', 'execute_set_title'], 20);


// ========================================== 
// FILTERS
// ========================================== 

// Add styles to TinyMCE body content
add_filter('tiny_mce_before_init', function( $mceInit ) {
	
	$styles = '@font-face { font-family: Lato; src: url(' . get_theme_file_uri() . '/fonts/lato-v14-latin-regular.ttf); }';
	$styles .= 'body.mce-content-body { \nfont-family: Lato, Arial, Helvetica, sans-serif; \n font-weight: normal; } ';

    if ( isset( $mceInit['content_style'] ) ) {
        $mceInit['content_style'] .= ' ' . $styles . ' ';
    } else {
        $mceInit['content_style'] = $styles . ' ';
    }
	
    return $mceInit;
});
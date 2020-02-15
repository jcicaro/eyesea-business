<?php 
/**
* Template Name: Page - General
*
* @package WordPress
*/

get_header(); ?>


<div class="container">
	
	<div class="row">
		<?php ESS_Component::the_jumbo_logo(); ?>
	</div>	
	
	<?php 
	if( have_rows('page_section') ): 
		$i=0;
	
		while ( have_rows('page_section') ) : the_row(); 
			$reverse_order_class = '';
			if ($i%2 == 0) {
				$reverse_order_class = 'order-md-last';
			}

			$main_image = get_sub_field('main_image');
	
			ESS_Component::the_page_general_section($main_image, $reverse_order_class);
	
			$i++;
		endwhile;
	
	endif;
	?>
	
</div>


<?php get_footer(); ?>
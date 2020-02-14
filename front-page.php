<?php get_header(); ?>


<div class="container">
	
	<div class="row">
		<?php ESS_Component::the_jumbo_logo(); ?>
	</div>	
	
	<?php 
	if( have_rows('home_items') ): 
		$i=0;
	
		while ( have_rows('home_items') ) : the_row(); 
			$reverse_order_class = '';
			if ($i%2 == 0) {
				$reverse_order_class = 'order-md-last';
			}

			$main_image = get_sub_field('main_image');
	
			ESS_Component::the_home_section($main_image, $reverse_order_class);
	
			$i++;
		endwhile;
	
	endif;
	?>

	<?php ESS_Component::the_contact_form(); ?>
	
</div>


<?php get_footer(); ?>
<?php

class ESS_Component {
	
	/*******************************************
	* Private site - Business Section
	********************************************/
	
	public static function the_acf_form($post_id, $post_type) {

		$post_type_label = is_archive() ? get_queried_object()->labels->singular_name : get_post_type_object($post_type)->labels->singular_name; 
		
		?>
		<div class="card">
			<div class="card-header">
				<div class="container d-flex justify-content-between align-content-center">
					<span class="nav-item dropdown">
						<a class="nav-link dropdown-toggle btn-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<strong><?php echo $post_type_label; ?></strong>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo esc_url(site_url('/form/?get_post=new_post&get_type=' . $post_type)); ?>">Create new</a>
						  	<a class="dropdown-item" href="<?php echo esc_url(site_url('/' . $post_type . '/')); ?>">Back to list</a>
						</div>
					</span>
					<span class="pr-3 pt-1">
						<?php if (is_single()) { the_title(); } ?>
					</span>
				</div>
			</div>
			<div class="card-body create-form">
				<div class="col card-body">
					<?php acf_form(array(
						'post_id'		=> $post_id,
						'post_title'	=> false,
						'post_content'	=> false,
						'form' => true,
						'html_submit_button'  => '<div class="acf-fields"><div class="acf-field"><input type="submit" class="acf-button button button-primary button-large btn btn-primary"" value="%s" /></div></div>',
						'new_post'		=> array(
							'post_type'		=> $post_type,
							'post_status'	=> 'private'
						)
					)); ?>
				</div>
			</div>
		</div>
		<?php
	}
	
	public static function the_table_header() {
		
		$meta_key = array_key_exists('order_key', $_GET) ? $_GET['order_key'] : '';
		$order = array_key_exists('order', $_GET) ? $_GET['order'] : 'ASC';
		$link_order = $order == 'ASC' ? 'DESC' : 'ASC';

		$post_type = is_archive() ? get_queried_object()->name : '';
		$class_name = ESS_Post::get_class_name($post_type);
		$fields = call_user_func($class_name . '::get_list_fields');
		?>
		
		<tr>
			<?php 

			foreach ($fields as $field_obj) { $field = $field_obj['name'];

			?>
			<th scope="col">
				<a class="text-dark" href="<?php echo '/' . $post_type . '/?order_key=' . $field . '&order=' . $link_order; ?>">
					<?php echo $field_obj['label']; // get_field_object($field)['label'] ?>

					<?php if ($meta_key == $field && $link_order == 'ASC') { ?>
					<i class="fa fa-angle-up" aria-hidden="true"></i>
					<?php } ?>

					<?php if ($meta_key == $field && $link_order == 'DESC') { ?>
					<i class="fa fa-angle-down" aria-hidden="true"></i>
					<?php } ?>
				</a>

			</th>
			<?php } ?>
		</tr>
		
		<?php
	}
	
	
	public static function the_cell($post_id, $field_obj, $col_num, $is_td=false) {
		$field = $field_obj['name'];
		$is_rel = $field_obj['is_relationship'] == true;
		?>

		<?php if($is_td) { echo '<td>'; } else { echo '<span>'; } ?>
			<?php if ($col_num == 0) { ?> 
			
			<a href="<?php the_permalink(); ?>">
				<?php echo get_field($field, $post_id); ?>
			</a>
			
			<?php } elseif ($is_rel) { if (get_field($field, $post_id)) { ?>
			
				<?php foreach(get_field($field, $post_id) as $f) {  ?>

				<a href="<?php echo get_permalink($f); ?>">
					<?php echo get_the_title($f); ?>
				</a>

				<?php } } ?>
			
			<?php } else { ?>
			
			<?php echo get_field($field, $post_id); ?>
			
			<?php } ?>
		
		<?php if($is_td) { echo '</td>'; } else { echo '</span>'; }  ?>


		<?php
	}
	
	
	public static function the_table_rows() {
		
		$meta_key = array_key_exists('order_key', $_GET) ? $_GET['order_key'] : '';
		$order = array_key_exists('order', $_GET) ? $_GET['order'] : 'ASC';

		$post_type = is_archive() ? get_queried_object()->name : '';
		$class_name = ESS_Post::get_class_name($post_type);
		$fields = call_user_func($class_name . '::get_list_fields');
		
		// Sample URL: https://wpmain-jci.codeanyapp.com/expense/?order_key=vendor&order=DESC
						
		global $wp_query;
		$args = array_merge( $wp_query->query_vars, 
							['orderby' => 'meta_value', 'meta_key' => $meta_key, 'order' => $order] );
		query_posts($args);

		while(have_posts()) { the_post(); $post_id = get_the_ID(); 

		?>

		<tr>
			<?php 
			foreach ($fields as $i=>$field_obj) { 
				self::the_cell($post_id, $field_obj, $i, true);
			} ?>
		</tr>

		<?php 
		} 
 		
	}
	
	public static function the_list() {
		
		?>
		<div class="row table-list">
			<div class="col table-responsive">

				<table class="table table-striped">
					<thead>
						<?php self::the_table_header(); ?>
					</thead>
					<tbody>
						<?php self::the_table_rows(); ?>
					<tbody>
				</table>
				
				<div class="d-flex justify-content-center">
					<?php self::bootstrap_pagination(); ?>
				</div>
				
				
				<?php wp_reset_query(); ?>
			</div>

		</div>
		<?php
	}
	
	public static function the_list_with_create() {
		$post_type = is_archive() ? get_queried_object()->name : '';
		$post_type_label = is_archive() ? get_queried_object()->labels->name : ''; 
		?>

		<div class="">
			<div class="container d-flex justify-content-between align-content-center mb-2 pl-0 pr-0">
				<span class="nav-item dropdown">
					<a class="nav-link dropdown-toggle btn-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<strong><?php echo $post_type_label; ?></strong>
					</a>
					<div class="dropdown-menu">
					  <a class="dropdown-item" href="<?= '/wp-json/sn/v1/update/' . $post_type ?>">Fetch records</a>
					</div>
				</span>
				
				<a href="<?php echo '/form/?get_post=new_post&get_type=' . $post_type; ?>">
					<button type="button" class="btn btn-primary bg-black"><i class="fa fa-plus" aria-hidden="true"></i></button>
				</a>
			</div>


		<?php ESS_Component::the_list(); // get_template_part('content'); ?>

		</div>
		<?php
	}
	
	/*
	 * custom pagination with bootstrap .pagination class
	 * source: http://www.ordinarycoder.com/paginate_links-class-ul-li-bootstrap/
	 */
	public static function bootstrap_pagination( $echo = true ) {
		global $wp_query;

		$big = 999999999; // need an unlikely integer

		$pages = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'type'  => 'array',
				'prev_next'   => true,
				'prev_text'    => __('« Prev'),
				'next_text'    => __('Next »'),
			)
		);

		if( is_array( $pages ) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

			$pagination = '<ul class="pagination pagination-sm">';

			foreach ( $pages as $page ) {
				$pagination .= '<li class="page-item">' . $page . '</li>';
			}

			$pagination .= '</ul>';

			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
	}
	
	/*******************************************
	* Public site - General 
	********************************************/
	
	public static function the_home_button_links() {
		?>

		<div>
			<?php if( have_rows('button_links') ): ?>
			<?php while ( have_rows('button_links') ) : the_row();  ?>
			<a href="<?php the_sub_field('link'); ?>" target="<?php the_sub_field('target'); ?>"><button class="btn btn-outline-light"><?php the_sub_field('button_label'); ?></button></a>

			<?php endwhile; ?>
			<?php endif; ?>	
		</div>

		<?php
	}
	
	public static function the_page_section_description() {
		?>

		<h3 class="lead-text"><?php the_sub_field('lead_text'); ?></h3>
		<p><?php the_sub_field('sub_text'); ?></p>

		
	<?php if( have_rows('paragraphs') ): ?>
	<div>
		<?php while ( have_rows('paragraphs') ) : the_row();  ?>

		<p>
			<small>
				<?php the_sub_field('paragraph'); ?>
			</small>
			
		</p>

		<?php endwhile; ?>
	</div>
	<?php endif; ?>	
		

		<?php self::the_home_button_links(); ?>

		<?php
	}
	
	public static function the_home_section_description() {
		?>

		<h3 class="lead-text"><?php the_sub_field('lead_text'); ?></h3>
		<p><?php the_sub_field('sub_text'); ?></p>
		<?php self::the_home_button_links(); ?>

		<?php
	}
	
	public static function the_home_section_main_image($main_image) {
		?>

			<?php if($main_image) {  ?>
				<img class="img-fluid w-100 h-100 img-mh-md" src="<?php echo esc_url($main_image['sizes']['large']); ?>" alt="<?php echo esc_attr($main_image['alt']); ?>" data-aos="fade" data-aos-delay="100">
			<?php } else { ?>
				<img class="img-fluid w-100 img-mh-md" src="<?php the_sub_field('image_url'); ?>" alt="" data-aos="fade" data-aos-delay="100">
			<?php } ?>

		<?php
	}
	
	
	
	/*******************************************
	* Public site - Front Page
	********************************************/
	
	public static function the_jumbo_logo() {
		?>

		<div class="col text-center p-4">
			<img class="img-responsive" src="https://eyesea.studio/wp-content/themes/eyesea-studio-v2/assets/img/eye-sea-studio-logo2.png" alt="" style="max-width: 70%; margin: auto">
		</div>

		<?php
	}
	
	public static function the_home_section($main_image, $reverse_order_class) { 
		?>

		<section class="home-item row no-gutters bg-black">

			<div class="home-item-txt-container col-md-6 p-5 d-flex flex-column align-self-center p-5 <?= $reverse_order_class ?>"  data-aos="fade-right" data-aos-delay="100">
				
				<?php self::the_home_section_description(); ?>

			</div>

			<div class="home-item-img-container col-md-6">
				<?php self::the_home_section_main_image($main_image); ?>
			</div>

		</section>

		<?php
	}
	
	public static function the_contact_form() {
		?>
		
<div class="bg-white contact-clean">
    <form data-aos="fade" data-bss-recipient="651af00c1422ae94ed09d3346eb678d9" data-bss-subject="From your website ">
        <h2 class="text-center">Contact Icy</h2>
        <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name"></div>
        <div class="form-group"><input class="border-dark form-control is-invalid" type="email" name="email" placeholder="Email"></div>
        <div class="form-group"><textarea class="form-control" name="message" placeholder="Message" rows="14"></textarea></div>
        <div class="form-group contact-submit"><button class="btn bg-black" type="submit">send </button></div>
    </form>
</div>

		<?php
	}
	
	/*******************************************
	* Public site - Page General
	********************************************/
	
	public static function the_page_general_section($main_image, $reverse_order_class) { 
		?>

		<section class="home-item row no-gutters bg-black">

			<div class="home-item-txt-container col-md-6 p-5 d-flex flex-column align-self-center p-5 <?= $reverse_order_class ?>"  data-aos="fade-right" data-aos-delay="100">
				
				<?php self::the_page_section_description(); ?>

			</div>

			<div class="home-item-img-container col-md-6">
				<?php self::the_home_section_main_image($main_image); ?>
			</div>

		</section>

		<?php
	}
	
	
	/*******************************************
	* Public site - Gallery
	********************************************/

	public static function the_gallery_nav() {
		$current_page_id = get_the_ID();
		$additional_class = '';
		$child_page = new WP_Query( [
			'post_type'      => 'page',
			'posts_per_page' => -1,
			'post_parent'    => wp_get_post_parent_id($current_page_id),
			'order'          => 'ASC',
			'orderby'        => 'menu_order'
		] );
		if ( $child_page->have_posts() ) : ?>

			<ul class="nav nav-pills justify-content-center gallery-nav mb-3">
				<li class="nav-item">
				  <a  class="nav-link" href="<?php echo home_url(); ?>" title="Home">Home</a>
				</li>

			<?php
			while ( $child_page->have_posts() ) : $child_page->the_post(); 
				if (get_the_ID() == $current_page_id) {
					$additional_class = 'active';
				}
				else {
					$additional_class = '';
				}
			?>


			  <li class="nav-item">
				  <a  class="nav-link <?php echo $additional_class; ?>" 
					 href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					  <?php the_title(); ?>
				  </a>
			  </li>

			<?php endwhile; ?>

			</ul>

			<?php
		endif; 
		wp_reset_postdata(); 
	}
	
	public static function the_gallery_section($images, $reverse_order_class, $col_num, $img_size) { 
		?>
		
		<section class="home-item row no-gutters bg-black">
		
			<div class="home-item-txt-container col-md-6 p-5 d-flex flex-column align-self-center p-5 <?= $reverse_order_class ?>"  data-aos="fade-right" data-aos-delay="100">
				<?php self::the_home_section_description(); ?>
			</div>

			<div class="home-item-img-container col-md-6">

				<div class="row no-gutters">

					<?php 
					if( $images ): ?>

							<?php foreach( $images as $image ): ?>

									<div class="col-<?php echo $col_num; ?>">
										<a href="<?php echo esc_url($image['sizes']['large']); // esc_url($image['url']); ?>" data-toggle="lightbox" data-title="<?php echo esc_attr($image['title']); ?>">
										 <img class="img-fluid w-100 h-100" style="object-fit: cover;" src="<?php echo esc_url($image['sizes'][$img_size]); ?>" alt="<?php echo esc_attr($image['alt']); ?>" data-aos="fade-in" data-aos-delay="100" />
										</a>
									</div>

							<?php endforeach; ?>

					<?php endif; ?>


				</div>
			</div>
		</section>

		<?php
	}
}


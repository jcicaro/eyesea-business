<?php

class ESS_Component {
	
	public static function the_acf_form($post_id, $post_type) {
		?>
		<div class="card">
			<div class="card-header">
				<ul class="nav nav-pills card-header-pills">
					<li class="nav-item">
						<a class="nav-link active" id="toggle-form" href="#">
							Toggle Form
						</a>
					</li>
				</ul>
			</div>
			<div class="card-body create-form">
				<div class="col card-body">
					<h3>
						<?php if (is_single()) { the_title(); } ?>
					</h3>
					<?php acf_form(array(
						'post_id'		=> $post_id,
						'post_title'	=> false,
						'post_content'	=> false,
						'form' => true,
						'html_submit_button'  => '<div class="acf-fields"><div class="acf-field"><input type="submit" class="acf-button button button-primary button-large btn btn-primary"" value="%s" /></div></div>',
						'new_post'		=> array(
							'post_type'		=> $post_type,
							'post_status'	=> 'publish'
						)
					)); ?>
				</div>
			</div>
		</div>
		<?php
	}
	
	public static function the_table_header() {
		$meta_key = $_GET['order_key'];
		$order = $_GET['order'] ?? 'ASC';
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
				<a href="<?php echo '/' . $post_type . '/?order_key=' . $field . '&order=' . $link_order; ?>">
					<?php echo get_field_object($field)['label'] ?>

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
	
	
	public static function the_cell($post_id, $field_obj, $col_num) {
		$field = $field_obj['name'];
		$is_rel = $field_obj['is_relationship'] == true;
		?>

		<td>
			<?php if ($col_num == 0) { ?> 
			
			<a href="<?php the_permalink(); ?>">
				<?php echo get_field($field, $post_id); ?>
			</a>
			
			<?php } elseif ($is_rel) { ?>
			
				<?php foreach(get_field($field, $post_id) as $f) {  ?>

				<a href="<?php echo get_permalink($f); ?>">
					<?php echo get_the_title($f); ?>
				</a>

				<?php } ?>
			
			<?php } else { ?>
			
			<?php echo get_field($field, $post_id); ?>
			
			<?php } ?>
		</td>

		<?php
	}
	
	
	public static function the_table_rows() {
		
		$meta_key = $_GET['order_key'];
		$order = $_GET['order'] ?? 'ASC';

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
				self::the_cell($post_id, $field_obj, $i);
			} ?>
		</tr>

		<?php 
		} 
		wp_reset_query();
						
	}
	
	public static function the_list() {
		
		$post_type_label = is_archive() ? get_queried_object()->label : ''; 
		
		?>
		<div class="row table-list">
			<div class="col">
				<h3>
					<?php echo $post_type_label; ?>
				</h3>
				
				<table class="table table-striped">
					<thead>
						<?php self::the_table_header(); ?>
					</thead>
					<tbody>
						<?php self::the_table_rows(); ?>
					<tbody>
				</table>
			</div>

		</div>
		<?php
	}
}


<?php get_header(); ?>

<?php 

// get_template_part('content'); 

$post_id = is_single() ? get_the_ID() : 'new_post';	
$post_type = is_single() ? get_post_type($post_id) : get_queried_object()->name; // 'expense';
ESS_Component::the_acf_form($post_id, $post_type);

?>

<?php get_footer(); ?>
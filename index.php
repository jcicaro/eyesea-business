<?php get_header(); ?>

<ul class="list-group mb-3">
        
<?php
//     echo ESS_SnHelper::getCompanies();
// ESS_AcfHelper::createExpense();
while(have_posts()) { 
    the_post(); 
    $post_id = get_the_ID(); 
    $post_type = get_post_type($post_id);
    $class_name = ESS_Post::get_class_name($post_type);
// 	$class_function = $class_name . '::get_list_fields';
	if (method_exists($class_name, 'get_list_fields')) {
		$fields = call_user_func($class_name . '::get_list_fields');	
	}
    ?>
    


<li class="list-group-item">
    <div>
        <a href="<?php the_permalink(); ?>">
            <h5><?php the_title(); ?></h5>
        </a>
        <span class="badge badge-secondary mb-2"><?php 
        echo get_post_type_object(get_post_type(get_the_ID()))->labels->singular_name; 
        ?></span>
    </div>
    <div class="text-muted">
        <?php
	if ($fields) {
    	foreach ($fields as $i=>$field_obj) { 
			if (get_field($field_obj['name'], $post_id)) {
				if ($i>0) {
					echo ' | ';
				}
				echo '<span>' . $field_obj['label'] . ':</span>';
        		ESS_Component::the_cell($post_id, $field_obj, $i);
			}
			
			
		} 
	}
    ?>
		
    </div>
    
</li>

        

<?php
}
?>
        
</ul>

<div class="d-flex justify-content-center">
	<?php bootstrap_pagination(); ?>
</div>

<?php get_footer(); ?>
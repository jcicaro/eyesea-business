<?php get_header(); ?>

<ul class="list-group">
        
<?php
//     echo ESS_SnHelper::getCompanies();
// ESS_AcfHelper::createExpense();
while(have_posts()) { 
    the_post(); 
    $post_id = get_the_ID(); 
    $post_type = get_post_type($post_id);
    $class_name = ESS_Post::get_class_name($post_type);
	$fields = call_user_func($class_name . '::get_list_fields');
    ?>
    


<li class="list-group-item">
    <div>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
        <span class="badge badge-secondary"><?php 
        echo get_post_type_object(get_post_type(get_the_ID()))->labels->singular_name; 
        ?></span>
    </div>
    <div>
        <?php
    foreach ($fields as $i=>$field_obj) { 
        ESS_Component::the_cell($post_id, $field_obj, $i);
    } 
    ?>
    </div>
    
</li>

        

<?php
}
?>
        
</ul>

<?php get_footer(); ?>
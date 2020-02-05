<?php get_header(); ?>

<table class="table table-striped">
    <tbody>
        
<?php
//     echo ESS_SnHelper::getCompanies();
// ESS_AcfHelper::createExpense();
while(have_posts()) { 
    the_post(); 
    $post_id = get_the_ID(); 
    ?>
    

<tr>
    <td>
        <a href="<?php the_permalink(); ?>">
            <?php echo get_post_type_object(get_post_type(get_the_ID()))->labels->singular_name; ?>
        </a>
    </td>
    <td>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </td>
</tr>
        

<?php
}
?>
        
    <tbody>
</table>

<?php get_footer(); ?>
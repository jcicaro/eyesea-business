<?php get_header(); ?>

<?php
/**
* Template Name: Form
*
* @package WordPress
*/

// https://wp-eye-sea-jci.codeanyapp.com/form/?get_post=new_post&get_type=income

$get_post = array_key_exists('get_post', $_GET) ? $_GET['get_post'] : 'new_post';
$get_type = array_key_exists('get_type', $_GET) ? $_GET['get_type'] : '';

ESS_Component::the_acf_form($get_post, $get_type);

?>

<?php get_footer(); ?>
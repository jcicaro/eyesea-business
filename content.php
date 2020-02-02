<?php 
	// ['date', 'amount', 'financial_year', 'type', 'description'];
?>
<div class="container">
	
	<section class="py-4">
		<?php 
		$acf_post_id = is_single() ? get_the_ID() : 'new_post';	
		$post_type = is_archive() ? get_queried_object()->name : ''; // 'expense';
		ESS_Component::the_acf_form($acf_post_id, $post_type);
		?>
	</section>
	
	<?php if (!is_single()) { ?>
	<section>
		<?php
// 		$ess_fields = ESS_AcfHelper::get_display_fields($post_type);
// 		ESS_Template::the_list($ess_fields);
		ESS_Component::the_list();
		?>
	</section>
	<?php } ?>
</div>
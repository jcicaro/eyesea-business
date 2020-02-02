<?php

class ESS_AcfHelper {
	
	public static function upsertPost($postType, $meta) {
		$postArr = ESS_AcfHelper::getPostsByKey($postType, 'correlation_id', $meta['sys_id']['value']);
		$crudMethods = ESS_AcfHelper::getCrudMethods($postType);
		if (count($postArr) > 0) {
			call_user_func($crudMethods['update'], $postArr[0]->ID, $meta);
		}
		else {
			call_user_func('ESS_AcfHelper::createPost', $postType, $meta);
		}
	}
	
	public static function createPost($postType, $meta) {
		$postInfo = ['post_type' => $postType, 'post_status'   => 'private'];
		$postId = wp_insert_post($postInfo);
		
		$crudMethods = ESS_AcfHelper::getCrudMethods($postType);
		
		call_user_func($crudMethods['update'], $postId, $meta);

		return $postId;
	}
	
	public static function updateExpense($postId, $meta) {

		update_field('date', $meta['date']['value'], $postId);
		update_field('type', $meta['type']['value'], $postId);
		update_field('amount', $meta['amount']['value'], $postId);
		update_field('financial_year', $meta['financial_year']['value'], $postId);
		update_field('description', $meta['description']['value'], $postId);
		update_field('reference_number', $meta['reference_number']['value'], $postId);
		
		$vendorRes = ESS_AcfHelper::getPostsByKey('vendor', 'correlation_id', $meta['vendor']['value']);
		if (count($vendorRes) > 0) {
			update_field('vendor', $vendorRes[0]->ID, $postId);
		}
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);
	}
	
	public static function updateIncome($postId, $meta) {
		
		update_field('date', $meta['date']['value'], $postId);
		update_field('type', $meta['type']['value'], $postId);
		update_field('amount', $meta['amount']['value'], $postId);
		update_field('financial_year', $meta['financial_year']['value'], $postId);
		
		if($meta['invoice']['value']) {
			$invRes = ESS_AcfHelper::getPostsByKey('invoice', 'correlation_id', $meta['invoice']['value']);
			if (count($invRes) > 0) {
				update_field('invoice', $invRes[0]->ID, $postId);
			}
		}
		
		if($meta['related_record']['value']) {
			$wsRes = ESS_AcfHelper::getPostsByKey('workshop', 'correlation_id', $meta['related_record']['value']);
			if (count($wsRes) > 0) {
				update_field('workshop', $wsRes[0]->ID, $postId);
			}
		}
		
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);
	}
	
	public static function updateInvoice($postId, $meta) {
		
		update_field('invoice_number', $meta['number']['value'], $postId);
		update_field('invoice_date', $meta['invoice_date']['value'], $postId);
		update_field('due_date', $meta['due_date']['value'], $postId);
		update_field('total', $meta['total']['value'], $postId);
		update_field('name', $meta['name']['value'], $postId);
		update_field('description', $meta['description']['value'], $postId);
		
		$custRes = ESS_AcfHelper::getPostsByKey('customer', 'correlation_id', $meta['customer']['value']);
		if (count($custRes) > 0) {
			update_field('customer', $custRes[0]->ID, $postId);
		}
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);
	}
	
	public static function updateWorkshop($postId, $meta) {
		
		update_field('workshop_date', $meta['workshop_date']['value'], $postId);
		update_field('platform', $meta['platform']['value'], $postId);
		update_field('number_of_people', $meta['number_of_people']['value'], $postId);
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);
	}
	
	public static function updateVendor($postId, $meta) {
		
		update_field('name', $meta['name']['value'], $postId);
		update_field('website', $meta['website']['value'], $postId);
		update_field('phone', $meta['phone']['value'], $postId);
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);
	}
	
	
	public static function updateCustomer($postId, $meta) {

		update_field('name', $meta['name']['value'], $postId);
		update_field('email', $meta['email']['value'], $postId);
		update_field('company', $meta['company']['display_value'], $postId);
		
		ESS_AcfHelper::updateCorrelation($postId, $meta);

		ESS_AcfHelper::setPostTitle($postId);

		return $postId;
	}

	
	public static function updateCorrelation($post_id, $meta) {
		update_field('correlation_id', $meta['sys_id']['value'], $post_id);
		update_field('correlation_meta', json_encode($meta, JSON_PRETTY_PRINT), $post_id);
	}
	
	public static function getPostsByKey($postType, $metaKey, $metaValue) {
		$post = get_posts([
			'numberposts' => -1,
			'post_type' => $postType,
			'post_status' => 'private', // ['private, publish'],
			'meta_key' => $metaKey,
			'meta_value' => $metaValue
		]);
		return $post;
	}
	
	public static function getCrudMethods($postType) {
		if ($postType == 'income') {
			return ['get_sn' => 'ESS_SnHelper::getIncome', 'update' => 'ESS_AcfHelper::updateIncome'];
		}
		else if ($postType == 'expense') {
			return ['get_sn' => 'ESS_SnHelper::getExpenses', 'update' => 'ESS_AcfHelper::updateExpense'];
		}
		else if ($postType == 'invoice') {
			return ['get_sn' => 'ESS_SnHelper::getInvoices', 'update' => 'ESS_AcfHelper::updateInvoice'];
		}
		else if ($postType == 'workshop') {
			return ['get_sn' => 'ESS_SnHelper::getWorkshops', 'update' => 'ESS_AcfHelper::updateWorkshop'];
		}
		else if ($postType == 'customer') {
			return ['get_sn' => 'ESS_SnHelper::getCustomers', 'update' => 'ESS_AcfHelper::updateCustomer'];
		}
		else if ($postType == 'vendor') {
			return ['get_sn' => 'ESS_SnHelper::getVendors', 'update' => 'ESS_AcfHelper::updateVendor'];
		}
	}
	
	public static function setPostTitle($post_id) {
		$post_type = get_post_type($post_id);
		$new_title = '--';

		if ($post_type == 'income') {
			$new_title = get_field('type', $post_id) . ' - ' . get_field('date', $post_id);
		}
		else if ($post_type == 'expense') {
			$new_title = get_field('date', $post_id) . ' - ' . get_field('type', $post_id) . ' - ' . get_field('amount', $post_id);
		}
		else if ($post_type == 'invoice') {
			$new_title = get_field('invoice_number', $post_id) . ' - ' . get_field('name', $post_id);
		}
		else if ($post_type == 'workshop') {
			$new_title = get_field('platform', $post_id) . ' - ' . get_field('workshop_date', $post_id); // get_field('platform', $post_id) + ' ' + get_field('workshop_date', $post_id);
		}
		else if ($post_type == 'customer') {
			$new_title = get_field('name', $post_id);
		}
		else if ($post_type == 'vendor') {
			$new_title = get_field('name', $post_id);
		}

		// Set the post data
		$new_post = array(
		  'ID'           => $post_id,
		  'post_title'   => $new_title,
		);

		// Remove the hook to avoid infinite loop. Please make sure that it has
		// the same priority (20)
		remove_action('acf/save_post', 'my_save_post', 20);

		// Update the post
		wp_update_post( $new_post );

		// Add the hook back
		add_action('acf/save_post', 'my_save_post', 20);
		
	}
	
	public static function get_display_fields($post_type) {
		if ($post_type == 'expense') {
			return ['date', 'amount', 'financial_year', 'type', 'REL::vendor', 'reference_number', 'description'];
		}
		else if ($post_type == 'income') {
			return ['date', 'amount', 'financial_year', 'type', 'REL::workshop', 'REL::invoice'];
		}
		else if ($post_type == 'invoice') {
			return ['invoice_number', 'invoice_date', 'due_date', 'total', 'name', 'customer', 'description'];
		}
		else if ($post_type == 'workshop') {
			return ['workshop_date', 'platform', 'number_of_people'];
		}
		else if ($post_type == 'customer') {
			return ['name', 'company', 'website', 'email', 'phone', 'street', 'city', 'post_code', 'notes'];
		}
		else if ($post_type == 'vendor') {
			return ['name', 'website', 'contact_person', 'phone', 'notes'];
		}

		return [];

	}
}
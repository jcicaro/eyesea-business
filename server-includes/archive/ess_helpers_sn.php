<?php

class ESS_SnHelper {
	
	public static function getExpenses() {
		$url = SN_BASE_URL . '/api/now/table/x_444953_eyesea_expense?sysparm_display_value=all';
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}
	
	public static function getIncome() {
		$url = SN_BASE_URL . '/api/now/table/x_444953_eyesea_income?sysparm_display_value=all';
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}
	
	public static function getInvoices() {
		$url = SN_BASE_URL . '/api/now/table/x_444953_eyesea_invoice?sysparm_display_value=all';
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}
	
	public static function getWorkshops() {
		$url = SN_BASE_URL . '/api/now/table/x_444953_eyesea_workshop?sysparm_display_value=all';
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}
	
	public static function getCustomers() {
		$queryStr = '&sysparm_query=companyISNOTEMPTY';
		return ESS_SnHelper::getUsers($queryStr);
	}
	
	public static function getUsers($queryStr) {
		// $url = SN_BASE_URL . '/api/now/table/sys_user?sysparm_display_value=true&sysparm_query=companyISNOTEMPTY';
		$url = SN_BASE_URL . '/api/now/table/sys_user?sysparm_display_value=all' . $queryStr;
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}
	
	public static function getVendors() {
		$url = SN_BASE_URL . '/api/now/table/core_company?sysparm_display_value=all';
		return ESS_SnHelper::getUrl($url, SN_USER, SN_PASSWORD);
	}

	
	public static function getUrl($endpoint, $username, $password) {
		
		$args = [
			'headers' => [
				'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
				'method'    => 'GET',
		  	]
		];
		$req = wp_remote_request( $endpoint, $args );
// 		$response_code = wp_remote_retrieve_response_code($req);
// 		$response_msg = wp_remote_retrieve_response_message($req);

// 		echo json_encode($req);
// 		echo json_encode($req['headers']);
// 		echo json_encode($req['body']);
		
		return $req['body'];
	}
	
	public static function getHandler($postType) {
		$crudMethods = ESS_AcfHelper::getCrudMethods($postType);
		$snResp = call_user_func($crudMethods['get_sn']);
		$snObj = json_decode($snResp, true);
		$snList = $snObj['result'];

		foreach ($snList as $obj) {
			ESS_AcfHelper::upsertPost($postType, $obj);
		}
		return json_encode($snList);
	}
	
}

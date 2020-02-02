<?php

class ESS_Helper {

	public static function to_string($obj) {
		if (is_array($obj)) { 
			return get_the_title($obj[0]);
	// 		return json_encode($obj); // implode(',', $obj); 
		}
		return $obj;
	}
	
}


<?php
/**
 * Custom theme functions
 *
 * @package Zhivo
 */

// Leave digits only in phone number
function zhivo_sanitize_phone($phone){
	$phone = preg_replace('/[^0-9]/', '', $phone);
	if(strlen($phone) === 12) {
		//Phone is 12 characters in length ### (##) ###-####
		return '+'.$phone;
	}
	return $phone;
}

// Add metaboxes to search
/* ADD META FIELD TO SEARCH QUERY */
function zhivo_add_meta_to_search($field){
	if(isset($GLOBALS['added_meta_field_to_search_query'])){
		$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

		return;
	}

	$GLOBALS['added_meta_field_to_search_query'] = array();
	$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

	add_filter('posts_join', function($join){
		global $wpdb;

		if (is_search()) {
			$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
		}

		return $join;
	});

	add_filter('posts_groupby', function($groupby){
		global $wpdb;

		if (is_search()) {
			$groupby = "$wpdb->posts.ID";
		}

		return $groupby;
	});

	add_filter('posts_search', function($search_sql){
		global $wpdb;

		$search_terms = get_query_var('search_terms');

		if(!empty($search_terms)){
			foreach ($search_terms as $search_term){
				$old_or = "OR ({$wpdb->posts}.post_content LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}')";
				$new_or = $old_or . " OR ({$wpdb->postmeta}.meta_value LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}' AND {$wpdb->postmeta}.meta_key IN (" . implode(', ', $GLOBALS['added_meta_field_to_search_query']) . "))";
				$search_sql = str_replace($old_or, $new_or, $search_sql);
			}
		}

		$search_sql = str_replace( " ORDER BY ", " GROUP BY $wpdb->posts.ID ORDER BY ", $search_sql );

		return $search_sql;
	});
}

// Get current url
function zhivo_current_url(){
	return home_url( $_SERVER['REQUEST_URI'] );
}

// Sanitize input data
function zhivo_filter_data($dataArr) {
	
	foreach ($dataArr as $key => $value) {
		//$value = strip_tags($value);
		$value = trim($value);
		$value = stripslashes($value);
		$value = htmlspecialchars($value, ENT_QUOTES);
		$dataArr[$key] = $value;
	}
	
	return $dataArr;
}

// Check email address
function zhivo_valid_email($email) {
	$separator = strpos($email, '@');
	$dot = strpos($email, '.');

	if ($separator === false || $dot === false) {
		return false;
	} else {
		return true;
	}
}

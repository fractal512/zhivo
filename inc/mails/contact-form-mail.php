<?php
// Contact form handler
function zhivo_contact_submit(){
	
	if ( ! isset($_POST['action']) || $_POST['action'] != 'zhivo-contact' ) {
		return;
	}
	
	if ( defined( 'DOING_AJAX' ) ){
		return;
	}
	
	if ( zhivo_try_submit() ) {
		$request_url = add_query_arg( array( 'contact_status' => 'success' ), zhivo_current_url() );
		header( "Location: " . $request_url );
		exit;
	}else{
		global $zhivo_contact_error;
		$zhivo_contact_error = true;
	}
}
add_action( 'init', 'zhivo_contact_submit' );

// Ajax contact form handler
function zhivo_ajax_contact_submit(){
	$json = array( 'status' => false );
	
	header('Content-Type: application/json; charset=UTF-8');
	
	if ( zhivo_try_submit() ) {
		$json['status'] = true;
		die( json_encode($json) );
	}else{
		header('HTTP/1.1 500 Internal Server Error');
		die( json_encode($json) );
	}
}
add_action( 'wp_ajax_zhivo-contact', 'zhivo_ajax_contact_submit' );
add_action( 'wp_ajax_nopriv_zhivo-contact', 'zhivo_ajax_contact_submit' );

// Try submit contact form
function zhivo_try_submit(){
	
	if( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'zhivo_form_contact' ) ){
		return false;
	}
	
	$form_data = zhivo_filter_data($_POST);
	
	if ( empty($form_data['contact_name']) ) {
		return false;
	}
	if ( empty($form_data['contact_email']) ) {
		return false;
	}
	if ( !empty($form_data['contact_email']) && !zhivo_valid_email($form_data['contact_email']) ) {
		return false;
	}
	if ( empty($form_data['contact_subject']) ) {
		return false;
	}
	if ( empty($form_data['contact_message']) ) {
		return false;
	}
	
	$mail_labels = array(
						'contact_name' => __('Client name', 'zhivo'),
						'contact_email' => __('Client E-mail', 'zhivo'),
						'contact_subject' => __('Subject', 'zhivo'),
						'contact_message' => __('Message', 'zhivo')
						);
	
	$mail_data = array();
	
	foreach( $mail_labels as $key => $value ){
		$mail_data[$key] = array(
								'label' => $value,
								'data' => $form_data[$key]
								);
	}
	
	zhivo_contact_mail($mail_data);
	return true;
}

// Send email with contact form data
function zhivo_contact_mail($mail_data){
	
	$to = get_bloginfo( 'admin_email' );
	$subject = $mail_data['contact_subject']['data'] . ' - ' . get_bloginfo( 'name' );
	$headers = array(
					//'From: ' . get_bloginfo( 'name' ) . ' <' . get_bloginfo( 'admin_email' ) . '>',
					"Content-Type: text/html; charset=UTF-8"
					);
	
	ob_start();
	include get_template_directory() . '/inc/mails/templates/contact-mail-template.php';
	$message = ob_get_clean();
	
	wp_mail( $to, $subject, $message, $headers );
}

function zhivo_wp_mail_from_name( $email_from ){
	return get_bloginfo( 'name' );
}
add_filter( 'wp_mail_from_name', 'zhivo_wp_mail_from_name' );

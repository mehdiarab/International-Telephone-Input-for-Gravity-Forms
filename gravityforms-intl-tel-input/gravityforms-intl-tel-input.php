<?php
/*
Plugin Name: International Telephone Input for Gravity Forms 
Plugin URI: https://github.com/WebCreatid/International-Telephone-Input-for-Gravity-Forms
Description: Transform Gravity Forms input phone to International Telephone Input.
Version: 1.0.2
Author: WebCreatid
Author URI: https://webcreatid.com
*/

if(is_plugin_active('gravityforms/gravityforms.php')){
	add_action( 'wp_enqueue_scripts', 'gf_iti_css',99);
	function gf_iti_css() {
	    wp_register_style('intlTelInput-styles', plugin_dir_url( __FILE__ ).'intl-tel-input/css/intlTelInput.min.css');
	    wp_enqueue_style('intlTelInput-styles' );
	    wp_register_style('gf_intlTelInput-styles', plugin_dir_url( __FILE__ ).'gf-intl-tel-input.css');
	    wp_enqueue_style('gf_intlTelInput-styles' );
	}

	add_action( 'wp_enqueue_scripts', 'gf_iti_js',99);
	function gf_iti_js() {
		wp_register_script('intlTelInput', plugin_dir_url( __FILE__ ).'intl-tel-input/js/intlTelInput.min.js', array('jquery'), false, true);
		wp_enqueue_script('intlTelInput');
		wp_register_script('gf_intlTelInput', plugin_dir_url( __FILE__ ).'gf-intl-tel-input.js', array('jquery','intlTelInput'), false, true);
		wp_enqueue_script('gf_intlTelInput');
		wp_register_script('gf_intlTelInput_utils', plugin_dir_url( __FILE__ ).'intl-tel-input/js/utils.js', array('jquery','intlTelInput'), false, true);
		wp_enqueue_script('gf_intlTelInput_utils');
	}

	add_action( 'gform_pre_submission', 'pre_submission_handler' );
	function pre_submission_handler($form){
	  $prefix = 'intlTelInput_full_phone-';
	  foreach($_POST as $key => $value){
	    if(strpos($key, $prefix) !== false){
	      $phone_input = str_replace($prefix, '', $key);
	      if(isset($_POST[$phone_input])){
		$_POST[$phone_input] = sanitize_text_field($value);
	      }
	    }
	  }
	}
}else{
	add_action('admin_notices', 'gf_iti_gf_not_activated');
}

function gf_iti_gf_not_activated() {
	echo '<div id="message" class="error">';
	echo '  <p><strong>"International Telephone Input for Gravity Forms"</strong> plugin requires <strong>Gravity Forms</strong> plugin activated to work ! Install Gravity Forms plugin to enjoy ;)</p>';
	echo '</div>';
}

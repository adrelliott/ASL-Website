<?php

/**
 * These arwe common functions that all GP child themes might use
 *
 * Add custom PHP to the functions.php file in the relevant child theme folder.
 */
 
 
 /**
 * Create a copyright statement
 * with privacy links
 */
add_shortcode('obl_footer', 'obl_generate_gdpr_links');
function obl_generate_gdpr_links() {
   echo 
      '<div id="obl_footer">
      	<p>&copy; ' . date('Y') . ' ' . get_bloginfo( 'name') . '<br>
	        <small>
	          <a href="' . get_site_url() . '/about/privacy" target="_blank">Privacy Policy</a>  |  
	          <a href="' . get_site_url() . '/about/cookies" target="_blank">Cookie Policy</a>  |  
	          <a href="' . get_site_url() . '/about/disclaimer" target="_blank">Disclaimer</a>  |  
	          <a href="' . get_site_url() . '/about/contact">Contact</a>
	        </small>
        </p>
      </div>';
     
}



/**
*	Build the GDPR policies using the templates
*	located in public_html/static/policies/{filename}
*	
*/
add_shortcode('obl_policy', 'obl_policyGenerator');
function obl_policyGenerator($attr = []) {
	
	// Set allowable params & fallback value
	$policies = [
		'privacy', 'disclaimer', 'cookies'
		];
	$policy = 'privacy';
	
	// See if an allowable param has been passed
	if( isset($attr['type']) && in_array($attr['type'], $policies)) {
		$policy = $attr['type'];
	}
		
	// load the required policy
	$filePath = '/home/customer/www/go.stealmymarketing.com/public_html/policies/' . $policy . '.php';
	$output = file_get_contents($filePath);

	// Replace the placeholders
	$output = str_replace("|*SITE_URL*|", get_site_url(), $output);
	
	return $output;
}




/**
 *  Allow us to display dynamic variables in the post/page using URL parameters
 *
 * @param 	$attributes     - Array of passed attributes, namely 'key' and 'default'
 * @var 	$key			- The key to look for in the URL/Query String array
 * @var 	$key			- The key to look for in the URL/Query String array
 *
 * @return string - returns $key, if that exists in the URL, or $default or if no $default passed, returns ""
 */

add_shortcode('dki', 'dynamic_content');

/**
* Use this shortcode to return dynamic content passed as a URL parameter
*
* Usage: [dki key='' default='']
* (Key = the url_param name, & default = the text to return if none found
*
* E.g. if we wrote this [dki key='city' default='London]
*	Scenario 1: 'city=Manchester' exists in the URL, function returns 'Manchester'
*	Scenario 2: 'city' does not appear in the UR, return 'London'
*
* 	NOTE: if you don't provide a 'default' then it returns nothing if no key is found
*/
function dynamic_content( $attributes ) {
	
	// Define all the variables
	$default = "";
	$return = "";
	$key = FALSE;
  
	// Get any passed attributes & sanitise them
	if ( ! empty( $attributes['key'] ) ) {
        $key = sanitize_text_field( $attributes['key'] );
	}
	if ( ! empty( $attributes['default'] ) ) {
        $default = sanitize_text_field( $attributes['default'] );
	}

	// Get all the query string parameters passed, if any
	parse_str( $_SERVER["QUERY_STRING"], $url_array);

	// Check for the 'key' passed as a URL param & return $default if none passed
	if ( $key != FALSE && array_key_exists( $key, $url_array ) ){
		$return = sanitize_text_field( $url_array[$key] );
	}
	else $return = $default;

	return esc_html( $return );
}



// Add Fontawesome to wordpress header
add_action('wp_head', 'obl_addFontawesome');
function obl_addFontawesome() {
	echo '<script src="https://kit.fontawesome.com/17cc4e1c48.js" crossorigin="anonymous"></script>';
}
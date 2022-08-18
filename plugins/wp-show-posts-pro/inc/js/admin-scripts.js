jQuery( document ).ready( function( $ ) {
	// Excerpt or full content	
	if ( 'full' !== $( '#wpsp-content-type' ).val() ) {
		$( '#butterbean-control-wpsp_link' ).hide();
		$( '#butterbean-control-wpsp_link_hover' ).hide();
	}
	if ( 'none' == $( '#wpsp-content-type' ).val() ) {
		$( '#butterbean-control-wpsp_text' ).hide();
	} else {
		$( '#butterbean-control-wpsp_text' ).show();
	}
	$( '#wpsp-content-type' ).change(function() {
		if ( 'full' == $( this ).val() ) {
			$( '#butterbean-control-wpsp_link' ).show();
			$( '#butterbean-control-wpsp_link_hover' ).show();
		} else {
			$( '#butterbean-control-wpsp_link' ).hide();
			$( '#butterbean-control-wpsp_link_hover' ).hide();
		}
		
		if ( 'none' == $( this ).val() ) {
			$( '#butterbean-control-wpsp_text' ).hide();
		} else {
			$( '#butterbean-control-wpsp_text' ).show();
		}
	});
	
	// Title
	if ( ! $( '#wpsp-include-title' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_title_color' ).hide();
		$( '#butterbean-control-wpsp_title_color_hover' ).hide();
	}
	
	$( '#wpsp-include-title' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_title_color' ).hide();
			$( '#butterbean-control-wpsp_title_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_title_color' ).show();
			$( '#butterbean-control-wpsp_title_color_hover' ).show();
		}
	});
	
	// Read more text
	if ( '' == $( 'input[name="butterbean_wp_show_posts_setting_wpsp_read_more_text"]' ).val() ) {
		$( '#butterbean-control-wpsp_read_more_background_color' ).hide();
		$( '#butterbean-control-wpsp_read_more_background_color_hover' ).hide();
		$( '#butterbean-control-wpsp_read_more_text_color' ).hide();
		$( '#butterbean-control-wpsp_read_more_text_color_hover' ).hide();
		$( '#butterbean-control-wpsp_read_more_border_color' ).hide();
		$( '#butterbean-control-wpsp_read_more_border_color_hover' ).hide();
	}
	
	$( 'input[name="butterbean_wp_show_posts_setting_wpsp_read_more_text"]' ).on( 'change keyup input', function() {
		if ( ! this.value ) {
			$( '#butterbean-control-wpsp_read_more_background_color' ).hide();
			$( '#butterbean-control-wpsp_read_more_background_color_hover' ).hide();
			$( '#butterbean-control-wpsp_read_more_text_color' ).hide();
			$( '#butterbean-control-wpsp_read_more_text_color_hover' ).hide();
			$( '#butterbean-control-wpsp_read_more_border_color' ).hide();
			$( '#butterbean-control-wpsp_read_more_border_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_read_more_background_color' ).show();
			$( '#butterbean-control-wpsp_read_more_background_color_hover' ).show();
			$( '#butterbean-control-wpsp_read_more_text_color' ).show();
			$( '#butterbean-control-wpsp_read_more_text_color_hover' ).show();
			$( '#butterbean-control-wpsp_read_more_border_color' ).show();
			$( '#butterbean-control-wpsp_read_more_border_color_hover' ).show();
		}
	});
	
	// Social icons
	if ( ! $( '#wpsp-twitter' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_twitter_color' ).hide();
		$( '#butterbean-control-wpsp_twitter_color_hover' ).hide();
	}
	
	$( '#wpsp-twitter' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_twitter_color' ).hide();
			$( '#butterbean-control-wpsp_twitter_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_twitter_color' ).show();
			$( '#butterbean-control-wpsp_twitter_color_hover' ).show();
		}
	});
	
	if ( ! $( '#wpsp-facebook' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_facebook_color' ).hide();
		$( '#butterbean-control-wpsp_facebook_color_hover' ).hide();
	}
	
	$( '#wpsp-facebook' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_facebook_color' ).hide();
			$( '#butterbean-control-wpsp_facebook_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_facebook_color' ).show();
			$( '#butterbean-control-wpsp_facebook_color_hover' ).show();
		}
	});
	
	if ( ! $( '#wpsp-googleplus' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_googleplus_color' ).hide();
		$( '#butterbean-control-wpsp_googleplus_color_hover' ).hide();
	}
	
	$( '#wpsp-googleplus' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_googleplus_color' ).hide();
			$( '#butterbean-control-wpsp_googleplus_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_googleplus_color' ).show();
			$( '#butterbean-control-wpsp_googleplus_color_hover' ).show();
		}
	});
	
	if ( ! $( '#wpsp-pinterest' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_pinterest_color' ).hide();
		$( '#butterbean-control-wpsp_pinterest_color_hover' ).hide();
	}
	
	$( '#wpsp-pinterest' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_pinterest_color' ).hide();
			$( '#butterbean-control-wpsp_pinterest_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_pinterest_color' ).show();
			$( '#butterbean-control-wpsp_pinterest_color_hover' ).show();
		}
	});
	
	if ( ! $( '#wpsp-love' ).is( ':checked' ) ) {
		$( '#butterbean-control-wpsp_love_color' ).hide();
		$( '#butterbean-control-wpsp_love_color_hover' ).hide();
	}
	
	$( '#wpsp-love' ).change(function() {
		if ( ! this.checked ) {
			$( '#butterbean-control-wpsp_love_color' ).hide();
			$( '#butterbean-control-wpsp_love_color_hover' ).hide();
		} else {
			$( '#butterbean-control-wpsp_love_color' ).show();
			$( '#butterbean-control-wpsp_love_color_hover' ).show();
		}
	});
});
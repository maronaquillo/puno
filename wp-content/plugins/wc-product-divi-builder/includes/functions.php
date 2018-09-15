<?php 

/**
* @since 1.4.0
*
* This File contains some helper funtions
*/

// exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// product page start html wrapper
function wcpb_woocommerce_output_content_wrapper(){

	$current_theme = wp_get_theme();

	// Divi theme
	if( strtolower( $current_theme->name ) == 'divi' || strtolower( $current_theme->template ) == 'divi' ){
		echo 
			'<div id="main-content">
				<div class="container">
					<div id="content-area" class="clearfix">
						<div id="left-area">';
	}

	// Extra theme
	if( strtolower( $current_theme->name ) == 'extra' || strtolower( $current_theme->template ) == 'extra' ){
		echo '
			<div id="main-content">
				<div class="container">
					<div id="content-area" class="clearfix">
						<div class="et_pb_extra_column_main">';
	}

}

// product page end html wrapper
function wcpb_woocommerce_output_content_wrapper_end(){

	$current_theme = wp_get_theme();

	// Divi theme
	if( strtolower( $current_theme->name ) == 'divi' || strtolower( $current_theme->template ) == 'divi' ){
		echo 
			'
						</div> <!-- #left-area -->
					</div> <!-- #content-area -->
				</div> <!-- .container -->
			</div> <!-- #main-content -->';
	}

	// Extra theme
	if( strtolower( $current_theme->name ) == 'extra' || strtolower( $current_theme->template ) == 'extra' ){
		echo '
						</div> <!-- .et_pb_extra_column_main -->
					</div> <!-- #content-area -->
				</div> <!-- .container -->
			</div> <!-- #main-content -->';
	}

}
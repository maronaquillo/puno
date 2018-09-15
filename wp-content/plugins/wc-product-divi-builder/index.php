<?php

/*
	Plugin Name: 	WC Product Builder For Divi
	Description: 	Use Divi builder to build awesome WooCommerce product layouts, works for Divi & Extra theme.
	Version: 		1.4.0
	Author: 		AbdElfatah AboElgit
	Author URI: 	https://www.divikingdom.com/
	Plugin URI: 	https://www.divikingdom.com/product/woocommerce-product-builder/
	Text Domain: 	wc-product-divi-builder
	Domain Path: 	/languages
	WC requires at least: 3.0.0
	WC tested up to: 3.3.0
*/
	
// exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
} 

define( 'DIVI_PRO_PL_NAME', 'WC Product Builder' );
define( 'DIVI_PRO_PL_PATH', plugin_dir_path( __FILE__ ) );
define( 'DIVI_PRO_PL_URL', plugin_dir_url( __FILE__ ) );
define( 'DIVI_PRO_LAYOUT_KEY', '_single_product_divi_layout' );

// helper functions
require DIVI_PRO_PL_PATH . 'includes/functions.php';

// load classes
require DIVI_PRO_PL_PATH . 'includes/classes/init.class.php';
require DIVI_PRO_PL_PATH . 'includes/classes/settings.class.php';
require DIVI_PRO_PL_PATH . 'includes/classes/metabox.class.php';
require DIVI_PRO_PL_PATH . 'includes/classes/shortcodes.class.php';
require DIVI_PRO_PL_PATH . 'includes/classes/license.class.php';
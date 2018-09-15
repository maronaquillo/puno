<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class WC_ET_BUILDER_SETTINGS{

	public function __construct(){
		add_action( 'admin_menu', array( $this, 'settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );

		// load Divi builder in single product edit page
		$plugin_settings = $this->plugin_settings();
		if( $plugin_settings['enable_divi_for_product_page'] == 1 ){
			add_filter( 'et_builder_post_types', array( $this, 'divi_builder_product_desc' ) );
			
			// use Divi Library for the description builder
			if( $plugin_settings['use_saved_layouts_for_product'] == 1 ){
				add_filter( 'et_pb_show_all_layouts_built_for_post_type', function(){
					return 'page';
				} );
			}
		}
	}

	// add settings menu page
	public function settings_page(){
		add_options_page( DIVI_PRO_PL_NAME, DIVI_PRO_PL_NAME, 'manage_options', 'wc-product-divi-builder', array( $this, 'settings_admin_page' ) );
	}

	// settings page callback
	public function settings_admin_page(){
		// load admin panel 
		require_once DIVI_PRO_PL_PATH . 'includes/admin/panel.php';
	}

	// register plugin setting
	public function register_plugin_settings(){
		// plugin settings
		register_setting( 'divi_woo_settings', 'divi_woo_settings', array( 'sanitize_callback' => array( $this, 'validate_plugin_settings' ) ) );

		// license key
		register_setting( 'wcpb_license_key', 'wcpb_license_key', array( 'sanitize_callback' => array( $this, 'validate_license_key' ) ) );
	}

	// set default settings & get saved settings from database
	public static function plugin_settings(){

		$default_settings = array(
			'default_product_layout' 		=> 0,
			'enable_divi_for_product_page' 	=> 0,
			'use_saved_layouts_for_product' => 0,
			'fullwidth_row_fix'				=> 1,
		); 
		$saved_settings = get_option( 'divi_woo_settings' );
		return wp_parse_args( $saved_settings, $default_settings );
	}

	// validate license key
	public function validate_license_key( $input_key ){

		if( !isset( $GLOBALS['wcpb_license'] ) ){
			return;
		}
		
		$result = $GLOBALS['wcpb_license']->activate( $input_key );

		if( isset( $result['status'] ) && $result['status'] == true ){

			add_settings_error( 'wcpb_license_key', 'wcpb_license_key', $result['message'], 'updated' );
			

		}elseif( isset( $result['status'] ) && $result['status'] == false ){

			add_settings_error( 'wcpb_license_key', 'wcpb_license_key', $result['message'], 'error' );
			
		}
		return sanitize_text_field( $input_key );

	}

	// validate plugin settings
	public function validate_plugin_settings( $s ){

		$settings = array(
			'default_product_layout' 		=> isset( $s['default_product_layout'] ) && is_numeric( $s['default_product_layout'] ) ? (int)$s['default_product_layout'] : 0,
			'enable_divi_for_product_page' 	=> isset( $s['enable_divi_for_product_page'] ) && $s['enable_divi_for_product_page'] == 1 ? 1 : 0,
			'use_saved_layouts_for_product' => isset( $s['use_saved_layouts_for_product'] ) && $s['use_saved_layouts_for_product'] == 1 ? 1 : 0,
			'fullwidth_row_fix'				=> isset( $s['fullwidth_row_fix'] ) && $s['fullwidth_row_fix'] == 1 ? 1 : 0,
		);

		return $settings;
	}

	// load Divi builder in single product edit page, works only for product description editor
	public function divi_builder_product_desc( $post_types ){
		$post_types[] = 'product';
		return $post_types;
	}
}

new WC_ET_BUILDER_SETTINGS();
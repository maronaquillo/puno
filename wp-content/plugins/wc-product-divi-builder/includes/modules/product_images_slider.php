<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Images_Slider extends ET_Builder_Module {

	function init() {
		$this->name       = esc_html__( 'Woo Product Images Slider', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_images_slider';

		$this->whitelisted_fields = array(
			'hide_thumbnails',
			'disable_lightbox',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array( 
			'hide_thumbnails' 	=> array( 'off' ),
			'disable_lightbox' 	=> array( 'off' ),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Slider Options', 'wc-product-divi-builder' ),
				),
			),
			
		);		

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'background' => array(
				'css' => array(
					'main' => "{$this->main_css_element}",
				),
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border' => array(
				'css' => array(
					'main' => "{$this->main_css_element}",
					'important' => 'all'
				),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'hide_thumbnails' => array(
				'label' => esc_html__( 'Hide Thumbnails', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'disable_lightbox' => array(
				'label' => esc_html__( 'Disable Lightbox', 'wc-product-divi-builder' ),
				'description' => esc_html__( 'Enabling this option will hide the magnifying glass over the image.', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'wc-product-divi-builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'wc-product-divi-builder' ),
					'tablet'  => esc_html__( 'Tablet', 'wc-product-divi-builder' ),
					'desktop' => esc_html__( 'Desktop', 'wc-product-divi-builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'wc-product-divi-builder' ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'visibility',
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'wc-product-divi-builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'wc-product-divi-builder' ),
				'toggle_slug' => 'admin_label',
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'wc-product-divi-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'wc-product-divi-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);

		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$hide_thumbnails      = $this->shortcode_atts['hide_thumbnails'];
		$disable_lightbox     = $this->shortcode_atts['disable_lightbox'];
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){

			if( $hide_thumbnails == 'on' ){
				add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

				// to remove the padding and margin created by the ol
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .flex-control-thumbs',
					'declaration' => 'display:none;',
				) );
			}

			if( $disable_lightbox == 'on' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .woocommerce-product-gallery__trigger',
					'declaration' => 'display:none !important;',
				) );
			}

			ob_start();
			do_action( 'woocommerce_before_single_product_summary' );
			$data = ob_get_contents();
			ob_end_clean();

		}else{
			return '';
		}

		$output = sprintf(
			'<div%2$s class="et_pb_module et_pb_woopro_images_slider%3$s">
				%1$s
			</div>',
			$data,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;			
	}
}
new ET_Builder_Module_WooPro_Images_Slider;
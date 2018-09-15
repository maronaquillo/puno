<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Excerpt extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Product Excerpt', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_excerpt';

		$this->whitelisted_fields = array(
			'text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->fields_defaults = array(
			'text_orientation'  => array( 'left' ),
		);
		
		$this->options_toggles = array(

			'advanced' => array(
				'toggles' => array(
					'text' => esc_html__( 'Text', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'text'   => array(
					'label'    => esc_html__( 'Text', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element}",
					),
					'font_size' => array(
						'default' => '14px',
					),
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border' => array(),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
		);
	}

	function get_fields() {
		$fields = array(
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'wc-product-divi-builder' ),
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
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$text_orientation     = $this->shortcode_atts['text_orientation'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_text_align_{$text_orientation}";

		// get product price
		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_excerpt' );
		}

		if( $data == '' ){
			return $data;
		}else{
			$output = sprintf(
				'<div%2$s class="et_pb_woopro_excerpt et_pb_module%3$s%4$s">
					%1$s
				</div>',
				$data,
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				$class
			);

			return $output;			
		}


	}
}
new ET_Builder_Module_WooPro_Excerpt;
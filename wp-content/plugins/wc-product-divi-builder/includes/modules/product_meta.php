<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Meta extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Product Meta', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_meta';

		$this->whitelisted_fields = array(
			'show_cats',
			'show_tags',
			'show_sku',
			'separate_line',
			'text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'show_cats'  		=> array( 'on' ),
			'show_tags'  		=> array( 'on' ),
			'show_sku'  		=> array( 'on' ),
			'single_line'  		=> array( 'off' ),
			'text_orientation'  => array( 'left' ),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Module Options', 'wc-product-divi-builder' ),
				),
			),
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
						'main' => "{$this->main_css_element} .product_meta, {$this->main_css_element} .product_meta a",
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
			'show_cats' => array(
				'label' => esc_html__( 'Show Categories', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_tags' => array(
				'label' => esc_html__( 'Show Tags', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_sku' => array(
				'label' => esc_html__( 'Show SKU', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'separate_line' => array(
				'label' => esc_html__( 'Show in separate lines', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'description' => esc_html__( 'Enabling this will show Categories, Tags and SKU each in a separate line', 'wc-product-divi-builder' ),
				'options' => array(
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
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
		$show_cats			= $this->shortcode_atts['show_cats'];
		$show_tags			= $this->shortcode_atts['show_tags'];
		$show_sku			= $this->shortcode_atts['show_sku'];
		$separate_line		= $this->shortcode_atts['separate_line'];
		$module_id          = $this->shortcode_atts['module_id'];
		$module_class       = $this->shortcode_atts['module_class'];
		$text_orientation   = $this->shortcode_atts['text_orientation'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_text_align_{$text_orientation}";

		if( $show_cats == 'off' ){
			$class .= ' hide-cats';
		}

		if( $show_tags == 'off' ){
			$class .= ' hide-tags';
		}

		if( $show_sku == 'off' ){
			$class .= ' hide-sku';
		}

		if( $separate_line == 'on' ){
			$class .= ' separate-line';
		}

		// get product price
		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_meta' );
		}

		if( $data == '' ){
			return $data;
		}else{
			$output = sprintf(
				'<div%2$s class="et_pb_woopro_meta et_pb_module%3$s%4$s">
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
new ET_Builder_Module_WooPro_Meta;
<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Price extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Product Price', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_price';

		$this->whitelisted_fields = array(
			'change_to_variation_price',
			'text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
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
						'line_height' => "{$this->main_css_element} p",
						'color' => "{$this->main_css_element} .price",
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
			'change_to_variation_price' => array(
				'label'             => esc_html__( 'Change to selected variable price', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options' => array( 
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
				'description'       => __( 'When you enable this, the price will change to the selected variation. <b>Works only with variable products</b>', 'wc-product-divi-builder' ),
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

		$change_to_variation_price  = $this->shortcode_atts['change_to_variation_price'];
		$module_id            		= $this->shortcode_atts['module_id'];
		$module_class         		= $this->shortcode_atts['module_class'];
		$text_orientation     		= $this->shortcode_atts['text_orientation'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_module et_pb_text_align_{$text_orientation}";
		
		$variation_html = '';
		
		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			global $product;

			if( $change_to_variation_price == 'on' && $product->is_type( 'variable' ) ){
				$class .= " change_to_variation_price";

				$variation_html .= "<div class='wcpb_selected_variation_price'></div>";
			}

			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_price' );
		}

		if( $data == '' ){
			return $data;
		}else{
			$output = sprintf(
				'<div%3$s class="et_pb_woopro_price%2$s%4$s">
					%5$s %1$s
				</div> <!-- .et_pb_text -->',
				$data,
				esc_attr( $class ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				$variation_html
			);

			return $output;			
		}

	}
}
new ET_Builder_Module_WooPro_Price;
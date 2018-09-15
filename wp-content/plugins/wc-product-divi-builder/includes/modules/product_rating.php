<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Rating extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Woo Product Rating', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_rating';

		$this->whitelisted_fields = array(
			'stars_color',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->options_toggles = array(

			'advanced' => array(
				'toggles' => array(
					'misc'	=> esc_html__( 'Miscellaneous', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'text'   => array(
					'label'    => esc_html__( 'Text', 'wc-product-divi-builder' ),
					'css'      => array(
						'color' => "{$this->main_css_element} a",
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
			'stars_color' => array(
				'label'             => esc_html__( 'Stars Color', 'wc-product-divi-builder' ),
				'type'     => 'color',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'misc',
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
		$stars_color      = $this->shortcode_atts['stars_color'];
		$module_id        = $this->shortcode_atts['module_id'];
		$module_class     = $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_rating' );
		}

		if( $data == '' ){
			return $data;
		}else{

			if( !empty( $stars_color ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% .star-rating span:before, .woocommerce-page %%order_class%% .star-rating span:before',
					'declaration' => "color: ". esc_attr( $stars_color ) ."!important;",
				) );
			}

			$output = sprintf(
				'<div%2$s class="et_pb_module et_pb_woopro_rating%3$s">
					%1$s
				</div>',
				$data,
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
			);

			return $output;			
		}
	}
}
new ET_Builder_Module_WooPro_Rating;
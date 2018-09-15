<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Notices extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Notices', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_notices';

		$this->whitelisted_fields = array(
			'text_orientation',
			'box_shadow_style_button',
			'box_shadow_horizontal_button',
			'box_shadow_vertical_button',
			'box_shadow_blur_button',
			'box_shadow_spread_button',
			'box_shadow_color_button',
			'box_shadow_position_button',
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
					'text' => esc_html__( 'Notice Text', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'text'   => array(
					'label'    => esc_html__( 'Notice', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => ".woocommerce {$this->main_css_element} .woocommerce-message, .woocommerce {$this->main_css_element} .woocommerce-error, .woocommerce {$this->main_css_element} .woocommerce-info",
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '18px',
					),
				),
			),
			'background' => array(
				'css' => array(
					'main' => ".woocommerce {$this->main_css_element} .woocommerce-message, .woocommerce {$this->main_css_element} .woocommerce-error, .woocommerce {$this->main_css_element} .woocommerce-info",
					'important' => 'all',
				),
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border' => array(
				'css' => array(
					'main' => ".woocommerce {$this->main_css_element} .woocommerce-message, .woocommerce {$this->main_css_element} .woocommerce-error, .woocommerce {$this->main_css_element} .woocommerce-info",
					'important' => 'all'
				),
			),
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Notice Button', 'wc-product-divi-builder' ),
					'css' => array(
						'main' => "{$this->main_css_element} .button",
						'important' => 'all',
					),
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
		$custom_icon          = $this->shortcode_atts['button_icon'];
		$button_custom        = $this->shortcode_atts['custom_button'];
		$button_bg_color      = $this->shortcode_atts['button_bg_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			$data = WC_ET_BUILDER::content_buffer( 'wc_print_notices' );
		}

		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_module et_pb_text_align_{$text_orientation}";

		if( $data == '' ){
			return $data;
		}else{

			if( $button_custom == 'on' ){

				if( $custom_icon != '' ){
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .button:after',
						'declaration' => "content: '". esc_attr( WC_ET_BUILDER::et_icon_css_content( $custom_icon ) ) ."' !important;",
					) );					
				}

				if( !empty( $button_bg_color ) ){

					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => 'body #page-container %%order_class%% .button',
						'declaration' => "background:". esc_attr( $button_bg_color ) ."!important;",
					) );
				}
	
			}

			$output = sprintf(
				'<div%3$s class="et_pb_woopro_notices%2$s%4$s">
					%1$s
				</div> <!-- .et_pb_text -->',
				$data,
				esc_attr( $class ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
			);

			return $output;			
		}

	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );

		if ( isset( $this->shortcode_atts['custom_button'] ) && $this->shortcode_atts['custom_button'] === 'on' ) {
			self::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% .button',
					'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_button' ) )
				)
			);
		}
	}
}
new ET_Builder_Module_WooPro_Notices;

<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Additional_Info extends ET_Builder_Module {

	public static $heading, $show_heading;
	public static function change_tab_heading( $hd ){
		
		if( self::$show_heading == 'off' ){
			$hd = '';
		}elseif( self::$show_heading == 'on' ){
			if( self::$heading != '' ){
				$hd = esc_attr( self::$heading );
			}
		}

		return $hd;
	}

	function init() {
		$this->name            = esc_html__( 'Woo Product Additional Info.', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_additional_info';

		$this->whitelisted_fields = array(
			'show_heading',
			'heading',
			'heading_text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'module_heading' => esc_html__( 'Module Heading', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->fields_defaults = array(
			'show_heading' => array( 'on' ),
			'heading_text_orientation' => array( 'left' ),
		);
		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Heading', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} > h2",
					),
					'font_size' => array(
						'default' => '26px',
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
		$this->custom_css_options = array(
			'header' => array(
				'label' => esc_html__( 'Heading', 'wc-product-divi-builder' ),
				'selector' => "{$this->main_css_element} > h2",
			),
		);
	}

	function get_fields() {
		$fields = array(
			'show_heading' => array(
				'label' => esc_html__( 'Show Heading', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'affects' => array(
					'heading',
					'heading_text_orientation',
				),
				'toggle_slug' => 'module_heading',
			),
			'heading' => array(
				'label'           => esc_html__( 'Custom Heading', 'wc-product-divi-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'The Heading of the module. If left empty, default is: Additional Information', 'wc-product-divi-builder' ),
				'depends_show_if'   => 'on',
				'toggle_slug' => 'module_heading',
			),
			'heading_text_orientation' => array(
				'label'             => esc_html__( 'Heading Orientation', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'toggle_slug' => 'module_heading',
				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'wc-product-divi-builder' ),
				'depends_show_if'   => 'on',
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
		self::$show_heading		= $this->shortcode_atts['show_heading'];
		self::$heading 			= $this->shortcode_atts['heading'];
		$module_id        		= $this->shortcode_atts['module_id'];
		$module_class     		= $this->shortcode_atts['module_class'];
		$heading_text_orientation     = $this->shortcode_atts['heading_text_orientation'];
		$module_class 			= ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			// only load additional_information if the product has
			$all_tabs = woocommerce_default_product_tabs();
			
			if( isset( $all_tabs['additional_information'] ) ){
				add_filter( 'woocommerce_product_additional_information_heading', array( $this, 'change_tab_heading' ) );
				$data = WC_ET_BUILDER::content_buffer( 'woocommerce_product_additional_information_tab' );

				// remove the new title to not affect the tabs module if used
				remove_filter( 'woocommerce_product_additional_information_heading', array( $this, 'change_tab_heading' ) );
			}	

			if( !empty( $heading_text_orientation ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% > h2',
					'declaration' => "text-align:". esc_attr( $heading_text_orientation ) .";",
				) );
			}
		
			$output = sprintf(
				'<div%2$s class="et_pb_woopro_additional_info et_pb_module%3$s">
					%1$s
				</div> <!-- .et_pb_module -->',
				$data,
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
			);

			return $output;			
		}

	}
}
new ET_Builder_Module_WooPro_Additional_Info;
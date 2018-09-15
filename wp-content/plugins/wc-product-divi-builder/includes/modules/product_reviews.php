<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Reviews extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Woo Product Reviews', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_reviews';

		$this->whitelisted_fields = array(
			'show_heading',
			'heading_text_orientation',
			'stars_color',
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
			'show_heading' => array( 'on' ),
			'heading_text_orientation' => array( 'left' ),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'module_heading' => esc_html__( 'Module Heading', 'wc-product-divi-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'misc'	=> esc_html__( 'Miscellaneous', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Heading', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} h2",
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
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Submit Button', 'wc-product-divi-builder' ),
					'css' => array(
						'main' => "{$this->main_css_element} #review_form #respond .form-submit input",
					),
				),
			),
		);

		$this->custom_css_options = array(
			'header' => array(
				'label' => esc_html__( 'Heading', 'wc-product-divi-builder' ),
				'selector' => "{$this->main_css_element} .woocommerce-Reviews-title",
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
					'heading_text_orientation',
				),
				'toggle_slug' => 'module_heading',
			),
			'heading_text_orientation' => array(
				'label'             => esc_html__( 'Heading Orientation', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'wc-product-divi-builder' ),
				'depends_show_if'   => 'on',
				'toggle_slug' => 'module_heading',
			),
			'stars_color' => array(
				'label'             => esc_html__( 'Stars Color', 'wc-product-divi-builder' ),
				'type'     => 'color',
				'toggle_slug' => 'misc',
				'tab_slug' => 'advanced',
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
		$stars_color      				= $this->shortcode_atts['stars_color'];
		$heading_text_orientation     	= $this->shortcode_atts['heading_text_orientation'];
		$show_heading     				= $this->shortcode_atts['show_heading'];
		$button_bg_color       			= $this->shortcode_atts['button_bg_color'];

		$module_id        = $this->shortcode_atts['module_id'];
		$module_class     = $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() && comments_open( get_the_ID() ) ){
			$data = WC_ET_BUILDER::content_buffer( 'comments_template' );

			if( !empty( $stars_color ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% .star-rating span:before, .woocommerce-page %%order_class%% .star-rating span:before, .woocommerce %%order_class%% p.stars a',
					'declaration' => "color: ". esc_attr( $stars_color ) ."!important;",
				) );
			}

			if( !empty( $button_bg_color ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => 'body #page-container %%order_class%% #review_form #respond .form-submit input',
					'declaration' => "background:". esc_attr( $button_bg_color ) ."!important;",
				) );
			}
			
			if( !empty( $heading_text_orientation ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .woocommerce-Reviews-title',
					'declaration' => "text-align: ". esc_attr( $heading_text_orientation ) .";",
				) );
			}

			if( $show_heading == 'off' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .woocommerce-Reviews-title',
					'declaration' => "display: none !important;",
				) );
			}

			$output = sprintf(
				'<div%2$s class="et_pb_module et_pb_woopro_reviews%3$s">
					%1$s
				</div> <!-- .et_pb_module -->',
				$data,
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
					'selector'    => '.woocommerce %%order_class%% #review_form #respond .form-submit input',
					'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_button' ) )
				)
			);
		}
	}
}
new ET_Builder_Module_WooPro_Reviews;
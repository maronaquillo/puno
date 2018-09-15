<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_AddToCart extends ET_Builder_Module {

	public static $button_text;
	public static function change_button_text( $btn_text ){
		if( !empty( self::$button_text ) ){
			$btn_text = esc_attr( self::$button_text );
		}
		return $btn_text;
	}

	function init() {
		$this->name       = esc_html__( 'Woo Add To Cart Button', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_add_to_cart';

		$this->whitelisted_fields = array(
			'button_text',
			'show_quantity',
			'hide_variation_price',
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

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'add_to_cart_button' => esc_html__( 'Add to Cart Button', 'wc-product-divi-builder' ),
					'quantity' => esc_html__( 'Quantity', 'wc-product-divi-builder' ),
					'variations' => esc_html__( 'Variations', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->fields_defaults = array(
			'show_quantity' 		=> array( 'on' ),
			'hide_variation_price' 	=> array( 'off' ),
		);

		$this->advanced_options = array(
			'fonts' => array(
				'quantity_input'   => array(
					'label'    => esc_html__( 'Quantity', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => array(
							".woocommerce {$this->main_css_element} .quantity input.qty",
						),
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '13px',
					),
				),
				'variation_description'   => array(
					'label'    => esc_html__( 'Variation Description', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => array(
							".woocommerce {$this->main_css_element} .woocommerce-variation-description",
						),
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '14px',
					),
				),
				'variation_prices'   => array(
					'label'    => esc_html__( 'Variation Prices', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => array(
							".woocommerce {$this->main_css_element} .woocommerce-variation-price .price",
						),
						'important' => 'all',
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
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Button', 'wc-product-divi-builder' ),
					'css' => array(
						'main' => "{$this->main_css_element} .cart .button",
						'important' => 'all',
					),
				),
			),
		);
		$this->custom_css_options = array(
			'button' => array(
				'label'    => esc_html__( 'Button', 'wc-product-divi-builder' ),
				'selector' => "body #page-container {$this->main_css_element} .cart .button",
				'no_space_before_selector' => true,
			),
			'quantity_input' => array(
				'label'    => esc_html__( 'Quantity', 'wc-product-divi-builder' ),
				'selector' => "
				.woocommerce .product {$this->main_css_element} .cart .quantity input.qty, 
				.woocommerce .product {$this->main_css_element} .cart .quantity,
				.woocommerce-page .product {$this->main_css_element} .cart .quantity input.qty,
				.woocommerce-page .product {$this->main_css_element} .cart .quantity",
			),
		);
	}

	function get_fields() {
		$fields = array(
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'wc-product-divi-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Add to cart', 'wc-product-divi-builder' ),
				'toggle_slug'       => 'add_to_cart_button',
			),
			'show_quantity' => array(
				'label' => esc_html__( 'Show Quantity Input', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug'       => 'quantity',
			),
			'hide_variation_price' => array(
				'label' => esc_html__( 'Hide Variation Price', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug'       => 'variations',
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

		self::$button_text      	= $this->shortcode_atts['button_text'];

		$show_quantity				= $this->shortcode_atts['show_quantity'];
		$hide_variation_price		= $this->shortcode_atts['hide_variation_price'];
		$module_id            		= $this->shortcode_atts['module_id'];
		$module_class         		= $this->shortcode_atts['module_class'];
		$custom_icon          		= $this->shortcode_atts['button_icon'];
		$button_custom        		= $this->shortcode_atts['custom_button'];
		$button_bg_color       		= $this->shortcode_atts['button_bg_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$class = " et_pb_module";

		$data = '';
		$hide_qty = '';

		if( function_exists( 'is_product' ) && is_product() ){

			if( $show_quantity == 'off' ){
				$hide_qty = ' hide-quantity';
			}

			add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'change_button_text' ) );
			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_add_to_cart' );

		}

		if( $custom_icon != '' && $button_custom == 'on' ){
			$custom_icon = 'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => 'body #page-container %%order_class%% .cart .button:after',
				'declaration' => "content: attr(data-icon);",
			) );
		}else{
			$custom_icon = '';
		}

		if( $data == '' ){
			return $data;
		}else{

			if( $hide_variation_price == 'on' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .woocommerce-variation-price',
					'declaration' => "display:none;",
				) );
			}

			if( !empty( $button_bg_color ) && $button_custom == 'on' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => 'body #page-container %%order_class%% .cart .button',
					'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
				) );
			}

			$output = str_replace(
				'class="single_add_to_cart_button button alt"',
				'class="single_add_to_cart_button button alt"' . $custom_icon 
				, $data
			);

			$output = sprintf(
				'<div %3$s class="et_pb_module et_pb_woopro_add_to_cart %2$s%4$s">
					%1$s
				</div>',
				$output,
				esc_attr( $module_class ),
				'id="' . esc_attr( $module_id ) . '"',
				$hide_qty
				);

			return $output;			
		}

	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );

		if ( isset( $this->shortcode_atts['custom_button'] ) && $this->shortcode_atts['custom_button'] === 'on' ) {
			self::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% button.button',
					'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_button' ) )
				)
			);
		}
	}	
}
new ET_Builder_Module_WooPro_AddToCart;
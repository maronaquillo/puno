<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Related extends ET_Builder_Module {

	public static $products_count;
	public static function change_pro_count( $args ){

		if( is_numeric( self::$products_count ) && self::$products_count > 0 ){
			$args['posts_per_page'] = self::$products_count;
		}
		return $args;
	}

	function init() {
		$this->name            = esc_html__( 'Woo Related Products', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_related_products';
		$this->whitelisted_fields = array(
			'show_heading',
			'heading_text_orientation',
			'stars_color',
			'use_overlay',
			'overlay_icon_color',
			'hover_overlay_color',
			'hover_icon',
			'products_count',
			'products_columns',
			'show_add_to_cart',
			'sale_badge_color',
			'admin_label',
			'module_id',
			'module_class',
		);
		$this->fields_defaults = array(
			'use_overlay' => array('on'),
			'show_heading' => array( 'on' ),
			'heading_text_orientation' => array( 'left' ),
			'products_columns' => array( '3' ),
		);
		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Header', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .related > h2",
						'important' => array( 'size', 'font-size', 'plugin_all' ),
					),
					'font_size' => array(
						'default' => '26px',
					),
				),
				'product_title' => array(
					'label'    => esc_html__( 'Product Title', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => ".woocommerce {$this->main_css_element} ul.products li.product h2.woocommerce-loop-product__title",
						'important' => array( 'size', 'font-size' ),
					),
					'font_size' => array(
						'default' => '14px',
					),
				),
				'product_price' => array(
					'label'    => esc_html__( 'Price', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => ".woocommerce {$this->main_css_element} ul.products li.product .price",
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
				'add_to_cart_button' => array(
					'label' => esc_html__( 'Add To Cart Button', 'wc-product-divi-builder' ),
					'css' => array(
						'main' => "{$this->main_css_element} ul.products li.product .button",
						'important' => 'all',
					),
				),
			),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'module_heading' => esc_html__( 'Module Heading', 'wc-product-divi-builder' ),
					'main_content' => esc_html__( 'Related Products', 'wc-product-divi-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay' => esc_html__( 'Product Image Overlay', 'wc-product-divi-builder' ),
					'misc'	=> esc_html__( 'Miscellaneous', 'wc-product-divi-builder' ),
				),
			),
			
		);

		$this->custom_css_options = array(
			'header' => array(
				'label' => esc_html__( 'Header', 'wc-product-divi-builder' ),
				'selector' => "{$this->main_css_element} .related > h2",
			),
			'product_title' => array(
				'label' => esc_html__( 'Product Title', 'wc-product-divi-builder' ),
				'selector' => ".woocommerce {$this->main_css_element} ul.products li.product h2.woocommerce-loop-product__title",
			),
			'product_price' => array(
				'label' => esc_html__( 'Product Price', 'wc-product-divi-builder' ),
				'selector' => ".woocommerce {$this->main_css_element} ul.products li.product .price",
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
			'products_count' => array(
				'label'			=> esc_html__( 'Products count', 'wc-product-divi-builder' ),
				'type'			=> 'number',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Products Count: Default is 3', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
			),
			'products_columns' => array(
				'label'			=> esc_html__( 'Products Columns', 'wc-product-divi-builder' ),
				'type'			=> 'select',
				'option_category' => 'layout',
				'options' => array(
					'0' => esc_html__( '-- Columns --', 'wc-product-divi-builder' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'description'     => esc_html__( 'Products Columns: Default is 3', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
			),
			'show_add_to_cart' => array(
				'label' => esc_html__( 'Show Add To Cart', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options' => array(
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'description'     => esc_html__( 'Enable this to display add to cart button under each product.', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
			),
			'use_overlay' => array(
				'label'             => esc_html__( 'Image Overlay', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'on' => esc_html__( 'On', 'wc-product-divi-builder' ),
					'off'  => esc_html__( 'Off', 'wc-product-divi-builder' ),
				),
				'affects'           => array(
					'overlay_icon_color',
					'hover_overlay_color',
					'hover_icon',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'overlay',
				'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'wc-product-divi-builder' ),
			),
			'overlay_icon_color' => array(
				'label'             => esc_html__( 'Overlay Icon Color', 'wc-product-divi-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'overlay',
				'description'       => esc_html__( 'Here you can define a custom color for the overlay icon', 'wc-product-divi-builder' ),
			),
			'hover_overlay_color' => array(
				'label'             => esc_html__( 'Hover Overlay Color', 'wc-product-divi-builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'overlay',
				'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'wc-product-divi-builder' ),
			),
			'hover_icon' => array(
				'label'               => esc_html__( 'Hover Icon Picker', 'wc-product-divi-builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'depends_show_if'     => 'on',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'overlay',
				'description'       => esc_html__( 'Here you can define a custom icon for the overlay', 'wc-product-divi-builder' ),
			),
			'stars_color' => array(
				'label'             => esc_html__( 'Rating Stars Color', 'wc-product-divi-builder' ),
				'type'     => 'color',
				'toggle_slug' => 'misc',
				'tab_slug' => 'advanced',
			),
			'sale_badge_color' => array(
				'label'             => esc_html__( 'Sale Badge Color', 'et_builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'toggle_slug' => 'misc',
				'tab_slug'          => 'advanced',
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

		self::$products_count 		= $this->shortcode_atts['products_count'];
		$products_columns 			= $this->shortcode_atts['products_columns'];
		$sale_badge_color        	= $this->shortcode_atts['sale_badge_color'];
		$heading_text_orientation   = $this->shortcode_atts['heading_text_orientation'];
		$show_heading     			= $this->shortcode_atts['show_heading'];
		$module_id        			= $this->shortcode_atts['module_id'];
		$module_class     			= $this->shortcode_atts['module_class'];
		$overlay_icon_color  		= $this->shortcode_atts['overlay_icon_color'];
		$hover_overlay_color 		= $this->shortcode_atts['hover_overlay_color'];
		$hover_icon          		= $this->shortcode_atts['hover_icon'];
		$use_overlay         		= $this->shortcode_atts['use_overlay'];
		$stars_color      			= $this->shortcode_atts['stars_color'];

		$show_add_to_cart 						= $this->shortcode_atts['show_add_to_cart'];
		$custom_add_to_cart_button  			= $this->shortcode_atts['custom_add_to_cart_button'];
		$add_to_cart_button_icon 				= $this->shortcode_atts['add_to_cart_button_icon'];
		$add_to_cart_button_icon_placement 		= $this->shortcode_atts['add_to_cart_button_icon_placement'];
		$add_to_cart_button_bg_color 			= $this->shortcode_atts['add_to_cart_button_bg_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'change_pro_count' ), 99 );		

			// show add to cart
			if( $show_add_to_cart == 'on' ){

				// add th button
				add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

				// add to cart button icon and background
				if( $custom_add_to_cart_button == 'on' ){

					// button icon
					if( $add_to_cart_button_icon !== '' ){
						$addToCartIconContent = WC_ET_BUILDER::et_icon_css_content( esc_attr($add_to_cart_button_icon) );

						$addToCartIconSelector = '';
						if( $add_to_cart_button_icon_placement == 'right' ){
							$addToCartIconSelector = '%%order_class%% li.product .button:after';
						}elseif( $add_to_cart_button_icon_placement == 'left' ){
							$addToCartIconSelector = '%%order_class%% li.product .button:before';
						}

						if( !empty( $addToCartIconContent ) && !empty( $addToCartIconSelector ) ){
							ET_Builder_Element::set_style( $function_name, array(
								'selector' => $addToCartIconSelector,
								'declaration' => "content: '{$addToCartIconContent}'!important;font-family:ETmodules!important;"
								)
							);					
						}						
					}

					// button background
					if( !empty( $add_to_cart_button_bg_color ) ){
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => 'body #page-container %%order_class%% .button',
							'declaration' => "background-color:". esc_attr( $add_to_cart_button_bg_color ) ."!important;",
						) );
					}
				}
			}

			// get the content
			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_output_related_products' );

			// remove add to cart so it doesn't affect other modules
			if( $show_add_to_cart == 'on' ){
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			}

			$class = 'et_pb_woopro_related_products et_pb_module ';

			if( $use_overlay == 'off' ){

				$class .= 'hide_overlay';

			}elseif( $use_overlay == 'on' ){

				// icon
				if( !empty( $hover_icon ) ){

					$icon_color = !( empty( $overlay_icon_color ) ) ? 'color: ' . esc_attr( $overlay_icon_color ) . ';' : '';

					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay:before, %%order_class%% .et_pb_extra_overlay:before',
						'declaration' => "content: '". esc_attr( WC_ET_BUILDER::et_icon_css_content( $hover_icon ) ) ."'; font-family: 'ETmodules' !important; {$icon_color}",
					) );

				}

				// hover background color
				if( !empty( $hover_overlay_color ) ){

					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay, %%order_class%% .et_pb_extra_overlay',
						'declaration' => "background: ". esc_attr( $hover_overlay_color ) .";",
					) );

				}
			}

			// stars color
			if( !empty( $stars_color ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% .star-rating span:before, .woocommerce-page %%order_class%% .star-rating span:before',
					'declaration' => "color: ". esc_attr( $stars_color ) ."!important;",
				) );
			}

			if( !empty( $heading_text_orientation ) ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .related > h2',
					'declaration' => "text-align: ". esc_attr( $heading_text_orientation ) .";",
				) );
			}

			if( $show_heading == 'off' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .related > h2',
					'declaration' => "display: none !important;",
				) );
			}

			if( !empty( $products_columns ) && is_numeric( $products_columns ) && $products_columns <= 5 ){
				$class .= ' woo_columns_' . $products_columns;
			}

			if ( '' !== $sale_badge_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% span.onsale',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						esc_html( $sale_badge_color )
					),
				) );
			}

			$output = sprintf(
				'<div%2$s class="%4$s%3$s">
					%1$s
				</div> <!-- .et_pb_module -->',
				$data,
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				$class
			);

			return $output;			
		}
		
	}

	public function process_box_shadow( $function_name ) {
		$boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );

		if ( isset( $this->shortcode_atts['custom_add_to_cart_button'] ) && $this->shortcode_atts['custom_add_to_cart_button'] === 'on' ) {
			self::set_style( $function_name, array(
					'selector'    => 'body #page-container %%order_class%% ul.products li.product .button',
					'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_add_to_cart_button' ) )
				)
			);
		}
	}
}
new ET_Builder_Module_WooPro_Related;
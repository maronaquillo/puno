<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Cover extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Woo Product Cover', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_cover';

		$this->whitelisted_fields = array(
			'default_bg_img',
			'show_breadcrumb',
			'show_title',
			'show_categories',
			'cats_separator',
			'background_layout',
			'text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'show_title' => array( 'on' ),
			'show_breadcrumb' => array( 'off' ),
			'show_categories' => array( 'on' ),
			'cats_separator' => array( ' / ' ),
			'background_layout' => array( 'light' ),
			'text_orientation'  => array( 'left' ),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Options', 'wc-product-divi-builder' ),
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
				'title'   => array(
					'label'    => esc_html__( 'Title', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .product_title",
					),
					'font_size' => array(
						'default' => '30px',
					),
				),
				'breadcrumb'   => array(
					'label'    => esc_html__( 'Breadcrumb', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-breadcrumb, {$this->main_css_element} .woocommerce-breadcrumb a",
					),
					'font_size' => array(
						'default' => '14px',
					),
				),
				'categories'   => array(
					'label'    => esc_html__( 'Categories', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .product_categories, {$this->main_css_element} .product_categories a",
					),
					'font_size' => array(
						'default' => '14px',
					),
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
			'title' => array(
				'label'    => esc_html__( 'Product Title', 'et_builder' ),
				'selector' => "{$this->main_css_element} .product_title",
			),
			'breadcrumb' => array(
				'label'    => esc_html__( 'Breadcrumb', 'et_builder' ),
				'selector' => "{$this->main_css_element} .woocommerce-breadcrumb",
			),
			'categories' => array(
				'label'    => esc_html__( 'Categories', 'et_builder' ),
				'selector' => "{$this->main_css_element} .product_categories",
			),
		);
	}

	function get_fields() {
		$fields = array(
			'default_bg_img' => array(
				'label' => esc_html__( 'Default Background Image', 'wc-product-divi-builder' ),
				'description' => esc_html__( 'This image will be used if no cover image has been chose for the product', 'wc-product-divi-builder' ),
				'type' => 'upload',
				'toggle_slug' => 'main_content',
			),
			'show_breadcrumb' => array(
				'label' => esc_html__( 'Show Breadcrumb', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_title' => array(
				'label' => esc_html__( 'Show Title', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_categories' => array(
				'label' => esc_html__( 'Show Categories', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'on' => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'affects' => array(
					'#et_pb_cats_separator',
				),	
				'toggle_slug' => 'main_content',		
			),
			'cats_separator' => array(
				'label' => esc_html__( 'Categories Separator', 'wc-product-divi-builder' ),
				'description' => esc_html__( 'Default: /', 'wc-product-divi-builder' ),
				'type' => 'text',
				'option_category' => 'configuration',
				'depends_show_if'   => 'on',
				'toggle_slug' => 'main_content',
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Color', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'wc-product-divi-builder' ),
					'dark'  => esc_html__( 'Light', 'wc-product-divi-builder' ),
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'wc-product-divi-builder' ),
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
		$show_title           = $this->shortcode_atts['show_title'];
		$show_breadcrumb      = $this->shortcode_atts['show_breadcrumb'];
		$show_categories      = $this->shortcode_atts['show_categories'];
		$cats_separator       = $this->shortcode_atts['cats_separator'];
		$default_bg_img       = $this->shortcode_atts['default_bg_img'];
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$text_orientation     = $this->shortcode_atts['text_orientation'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		
		if( function_exists( 'is_product' ) && is_product() ){
			global $post, $product;
			// get cover image
			if( $cover_img = get_post_meta( $post->ID, '_product_cover_img_url', true ) ){
				$cover_img = esc_attr( $cover_img );
			}else{
				$cover_img = !empty( $default_bg_img ) ? esc_attr( $default_bg_img ) : '';
			}

			// get product title
			$title = '';
			if( $show_title == 'on' ){
				$title = WC_ET_BUILDER::content_buffer( 'woocommerce_template_single_title' );
			}
			
			// get breadcrumb
			$breadcrumb = '';
			if( $show_breadcrumb == 'on' ){
				$breadcrumb = WC_ET_BUILDER::content_buffer( 'woocommerce_breadcrumb' );
			}
			
			// get categories
			$categories = '';
			if( $show_categories == 'on' ){
				$sep = ' / ';
				if( !empty( $cats_separator ) ){
					$sep = esc_attr( $cats_separator );
				}

				if( version_compare( WC()->version, '3.0.0', '>=' ) ){
					$categories = wc_get_product_category_list( $post->ID, $sep, '<div class="product_categories"><span class="posted_in">', '</span></div>' );
				}else{
					$categories = $product->get_categories( $sep, '<div class="product_categories"><span class="posted_in">', '</span></div>' );
				}
			}

			$class = " et_pb_bg_layout_{$background_layout} et_pb_text_align_{$text_orientation}";
			if ( is_rtl() && 'left' === $text_orientation ) {
				$text_orientation = 'right';
			}

			$content = $breadcrumb . $title . $categories;

			// add background image
			$bg_style = '';
			if( $cover_img != '' ){
				$bg_style = "style='background-image:url({$cover_img}); background-size: cover;background-position: center;'";
			}

			$output = sprintf('
				<div%2$s class="et_pb_module et_pb_woopro_cover%1$s%3$s" %5$s>
					%4$s
				</div>',
				$class,
				$module_id ? ' id="' . esc_attr( $module_id ) . '"' : '', 
				$module_class ? esc_attr( $module_class ) : '',
				$content,
				$bg_style
			);

			return $output;

		}else{
			return '';
		}
	}	
}
new ET_Builder_Module_WooPro_Cover;

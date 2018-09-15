<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Tabs extends ET_Builder_Module {

	public static $tabs_to_remove = array();
	public static function remove_tabs( $tabs ){
		if( count( self::$tabs_to_remove ) ){

			foreach( self::$tabs_to_remove as $tab ){
				unset( $tabs[$tab] );
			}
		}
		return $tabs;
	}
	function init() {
		$this->name             = esc_html__( 'Woo Product Tabs', 'wc-product-divi-builder' );
		$this->slug             = 'et_pb_woopro_tabs';
		$this->post_types 		= array( 'post', 'page', 'project' ); // this will remove the module from the product description builder

		$this->whitelisted_fields = array(
			'show_desc',
			'show_add_info',
			'show_reviews',
			'remove_default_style',
			'remove_tabs_labels',
			'tabs_head_text_orientation',
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

			'ul_type',
			'ul_position',
			'ul_item_indent',
			'ol_type',
			'ol_position',
			'ol_item_indent',
			'quote_border_weight',
			'quote_border_color',
		);

		$this->fields_defaults = array( 
			'show_desc' 					=> array( 'on' ),
			'show_add_info' 				=> array( 'on' ),
			'show_reviews' 					=> array( 'on' ),
			'remove_default_style' 			=> array( 'off' ),
			'tabs_head_text_orientation' 	=> array( 'left' ),
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Module Options', 'wc-product-divi-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'misc'	=> esc_html__( 'Miscellaneous', 'wc-product-divi-builder' ),
					'text' => array(
						'title'    => esc_html__( 'Description', 'et_builder' ),
						'priority' => 45,
						'tabbed_subtoggles' => true,
						'bb_icons_support' => true,
						'sub_toggles' => array(
							'p'     => array(
								'name' => 'P',
								'icon' => 'text-left',
							),
							'a'     => array(
								'name' => 'A',
								'icon' => 'text-link',
							),
							'ul'    => array(
								'name' => 'UL',
								'icon' => 'list',
							),
							'ol'    => array(
								'name' => 'OL',
								'icon' => 'numbered-list',
							),
							'quote' => array(
								'name' => 'QUOTE',
								'icon' => 'text-quote',
							),
						),
					),
					'header' => array(
						'title'    => esc_html__( 'Description Heading', 'et_builder' ),
						'priority' => 49,
						'tabbed_subtoggles' => true,
						'sub_toggles' => array(
							'h1' => array(
								'name' => 'H1',
								'icon' => 'text-h1',
							),
							'h2' => array(
								'name' => 'H2',
								'icon' => 'text-h2',
							),
							'h3' => array(
								'name' => 'H3',
								'icon' => 'text-h3',
							),
							'h4' => array(
								'name' => 'H4',
								'icon' => 'text-h4',
							),
							'h5' => array(
								'name' => 'H5',
								'icon' => 'text-h5',
							),
							'h6' => array(
								'name' => 'H6',
								'icon' => 'text-h6',
							),
						),
					),
					'width' => array(
						'title'    => esc_html__( 'Sizing', 'et_builder' ),
						'priority' => 65,
					),
				),
			),
			
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'header'   => array(
					'label'    => esc_html__( 'Tabs Headers', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a, body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a, .woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header",
					),
					'font_size' => array(
						'default' => '16px',
					),
					'important' => array(),
				),
				'active_tab'   => array(
					'label'    => esc_html__( 'Active Tab Header', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li.active a, body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li.active a, .woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header.ui-accordion-header-active span::before, .woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header.ui-accordion-header-active .title",
					),
					'font_size' => array(
						'default' => '16px',
					),
				),
				'tab_header_hover'   => array(
					'label'    => esc_html__( 'Tab Header Hover', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "
							body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a:hover, 
							body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a:hover, 
							.woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header:hover",
					),
					'font_size' => array(
						'default' => '16px',
					),
				),
				'text'   => array(
					'label'    => esc_html__( 'Text', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description p",
					),
					'line_height' => array(
						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
					),
					'font_size' => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'p',
					'hide_text_align' => true,
				),
				'link'   => array(
					'label'    => esc_html__( 'Link', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description a",
						'color' => "{$this->main_css_element} .woocommerce-Tabs-panel--description a",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'a',
				),
				'ul'   => array(
					'label'    => esc_html__( 'Unordered List', 'et_builder' ),
					'css'      => array(
						'main'        => "{$this->main_css_element} .woocommerce-Tabs-panel--description ul",
						'color'       => "{$this->main_css_element} .woocommerce-Tabs-panel--description ul",
						'line_height' => "{$this->main_css_element} .woocommerce-Tabs-panel--description ul li",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '14px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'ul',
				),
				'ol'   => array(
					'label'    => esc_html__( 'Ordered List', 'et_builder' ),
					'css'      => array(
						'main'        => "{$this->main_css_element} .woocommerce-Tabs-panel--description ol",
						'color'       => "{$this->main_css_element} .woocommerce-Tabs-panel--description ol",
						'line_height' => "{$this->main_css_element} .woocommerce-Tabs-panel--description ol li",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '14px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'ol',
				),
				'quote'   => array(
					'label'    => esc_html__( 'Blockquote', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description blockquote, {$this->main_css_element} .woocommerce-Tabs-panel--description blockquote p",
						'color' => "{$this->main_css_element} .woocommerce-Tabs-panel--description blockquote, {$this->main_css_element} .woocommerce-Tabs-panel--description blockquote p",
					),
					'line_height' => array(
						'default' => '1em',
					),
					'font_size' => array(
						'default' => '14px',
					),
					'toggle_slug' => 'text',
					'sub_toggle'  => 'quote',
				),
				'header_1'   => array(
					'label'    => esc_html__( 'Heading', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h1",
					),
					'font_size' => array(
						'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h1',
				),
				'header_2'   => array(
					'label'    => esc_html__( 'Heading 2', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h2",
					),
					'font_size' => array(
						'default' => '26px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h2',
				),
				'header_3'   => array(
					'label'    => esc_html__( 'Heading 3', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h3",
					),
					'font_size' => array(
						'default' => '22px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h3',
				),
				'header_4'   => array(
					'label'    => esc_html__( 'Heading 4', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h4",
					),
					'font_size' => array(
						'default' => '18px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h4',
				),
				'header_5'   => array(
					'label'    => esc_html__( 'Heading 5', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h5",
					),
					'font_size' => array(
						'default' => '16px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h5',
				),
				'header_6'   => array(
					'label'    => esc_html__( 'Heading 6', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .woocommerce-Tabs-panel--description h6",
					),
					'font_size' => array(
						'default' => '14px',
					),
					'line_height' => array(
						'default' => '1em',
					),
					'toggle_slug' => 'header',
					'sub_toggle'  => 'h6',
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
					'label' => esc_html__( 'Submit Review Button', 'wc-product-divi-builder' ),
					'css' => array(
						'main' => "{$this->main_css_element} #review_form #respond .form-submit input",
					),
				),
			),
		);

		$this->custom_css_options = array(
			'header' => array(
				'label' => esc_html__( 'Tabs Headers', 'wc-product-divi-builder' ),
				'selector' => "body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a, body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a, .woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header",
			),
			'active_tab' => array(
				'label' => esc_html__( 'Active Tab Header', 'wc-product-divi-builder' ),
				'selector' => "
					body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li.active a,
					body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li.active a,
					.woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header.ui-accordion-header-active .title",
			),
			'hover_tab' => array(
				'label' => esc_html__( 'On Tabs Headers Hover', 'wc-product-divi-builder' ),
				'selector' => "
					body.woocommerce div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a:hover, 
					body.woocommerce #content-area div.product {$this->main_css_element} .woocommerce-tabs ul.tabs li a:hover, 
					.woo_product_divi_layout .et_pb_woopro_tabs .extra-woocommerce-details-accordion .header:hover",
			),
		);
	}

	function get_fields() {
		$fields = array(
			'show_desc' => array(
				'label' => esc_html__( 'Show Description', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_add_info' => array(
				'label' => esc_html__( 'Show Additional Info.', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'show_reviews' => array(
				'label' => esc_html__( 'Show Reviews', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array( 
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'remove_default_style' => array(
				'label' => esc_html__( 'Remove Default Style', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'description' => esc_html__( 'This will remove borders and heading background FOR Divi Theme ONLY', 'wc-product-divi-builder' ),
				'options_category' => 'configuration',
				'options' => array( 
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'remove_tabs_labels' => array(
				'label' => esc_html__( 'Remove Tabs Labels', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'description' => esc_html__( 'This will remove tabs labels.', 'wc-product-divi-builder' ),
				'options_category' => 'configuration',
				'options' => array( 
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'tabs_head_text_orientation' => array(
				'label'             => esc_html__( 'Tabs Headers Text Orientation', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'description'       => esc_html__( 'This controls how your tabs headings are aligned within the module.', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
			),
			'stars_color' => array(
				'label'             => esc_html__( 'Reviews Stars Color', 'wc-product-divi-builder' ),
				'type'     => 'color-alpha',
				'default' => '#2ea3f2',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'misc',
			),
			'ul_type' => array(
				'label'             => esc_html__( 'Unordered List Style Type', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'disc'    => esc_html__( 'Disc', 'et_builder' ),
					'circle'  => esc_html__( 'Circle', 'et_builder' ),
					'square'  => esc_html__( 'Square', 'et_builder' ),
					'none'    => esc_html__( 'None', 'et_builder' ),
				),
				'priority'          => 80,
				'default'           => 'disc',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'sub_toggle'        => 'ul',
			),
			'ul_position' => array(
				'label'             => esc_html__( 'Unordered List Style Position', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'outside' => esc_html__( 'Outside', 'et_builder' ),
					'inside'  => esc_html__( 'Inside', 'et_builder' ),
				),
				'priority'          => 85,
				'default'           => 'outside',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'sub_toggle'        => 'ul',
			),
			'ul_item_indent' => array(
				'label'           => esc_html__( 'Unordered List Item Indent', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'sub_toggle'      => 'ul',
				'priority'        => 90,
				'default'         => '0px',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),
			'ol_type' => array(
				'label'             => esc_html__( 'Ordered List Style Type', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'decimal'              => 'decimal',
					'armenian'             => 'armenian',
					'cjk-ideographic'      => 'cjk-ideographic',
					'decimal-leading-zero' => 'decimal-leading-zero',
					'georgian'             => 'georgian',
					'hebrew'               => 'hebrew',
					'hiragana'             => 'hiragana',
					'hiragana-iroha'       => 'hiragana-iroha',
					'katakana'             => 'katakana',
					'katakana-iroha'       => 'katakana-iroha',
					'lower-alpha'          => 'lower-alpha',
					'lower-greek'          => 'lower-greek',
					'lower-latin'          => 'lower-latin',
					'lower-roman'          => 'lower-roman',
					'upper-alpha'          => 'upper-alpha',
					'upper-greek'          => 'upper-greek',
					'upper-latin'          => 'upper-latin',
					'upper-roman'          => 'upper-roman',
					'none'                 => 'none',
				),
				'priority'          => 80,
				'default'           => 'decimal',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'sub_toggle'        => 'ol',
			),
			'ol_position' => array(
				'label'             => esc_html__( 'Ordered List Style Position', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'outside' => esc_html__( 'Outside', 'et_builder' ),
					'inside'  => esc_html__( 'Inside', 'et_builder' ),
				),
				'priority'          => 85,
				'default'           => 'outside',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'sub_toggle'        => 'ol',
			),
			'ol_item_indent' => array(
				'label'           => esc_html__( 'Ordered List Item Indent', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'sub_toggle'      => 'ol',
				'priority'        => 90,
				'default'         => '0px',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),
			'quote_border_weight' => array(
				'label'           => esc_html__( 'Blockquote Border Weight', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'sub_toggle'      => 'quote',
				'priority'        => 85,
				'default'         => '5px',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
			),
			'quote_border_color' => array(
				'label'           => esc_html__( 'Blockquote Border Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'custom_color'    => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'text',
				'sub_toggle'      => 'quote',
				'field_template'  => 'color',
				'priority'        => 90,
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
		$show_desc						= $this->shortcode_atts['show_desc'];
		$show_add_info					= $this->shortcode_atts['show_add_info'];
		$show_reviews					= $this->shortcode_atts['show_reviews'];
		$remove_default_style			= $this->shortcode_atts['remove_default_style'];
		$remove_tabs_labels				= $this->shortcode_atts['remove_tabs_labels'];
		$tabs_head_text_orientation		= $this->shortcode_atts['tabs_head_text_orientation'];
		$stars_color      				= $this->shortcode_atts['stars_color'];
		$button_bg_color       			= $this->shortcode_atts['button_bg_color'];

		$ul_type              = $this->shortcode_atts['ul_type'];
		$ul_position          = $this->shortcode_atts['ul_position'];
		$ul_item_indent       = $this->shortcode_atts['ul_item_indent'];
		$ol_type              = $this->shortcode_atts['ol_type'];
		$ol_position          = $this->shortcode_atts['ol_position'];
		$ol_item_indent       = $this->shortcode_atts['ol_item_indent'];
		$quote_border_weight  = $this->shortcode_atts['quote_border_weight'];
		$quote_border_color   = $this->shortcode_atts['quote_border_color'];
		
		$module_id      				= $this->shortcode_atts['module_id'];
		$module_class   				= $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$class = ' et_pb_module';
		$class .= $tabs_head_text_orientation != '' ? ' tabs-head-' . esc_attr( $tabs_head_text_orientation ) : '';
		$class .= $remove_default_style == 'on' ? ' remove-default-style' : '';

		$data = '';
		if( function_exists( 'is_product' ) && is_product() ){
			
			if( $show_desc == 'off' ){
				self::$tabs_to_remove[] = 'description';
			}

			if( $show_add_info == 'off' ){
				self::$tabs_to_remove[] = 'additional_information';
			}

			if( $show_reviews == 'off' ){
				self::$tabs_to_remove[] = 'reviews';
			}

			add_filter( 'woocommerce_product_tabs', array( $this, 'remove_tabs' ), 98 );

			$data = WC_ET_BUILDER::content_buffer( 'woocommerce_output_product_data_tabs' );

			if( $remove_tabs_labels == 'on' ){

				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .woocommerce-Tabs-panel--description > h2, %%order_class%% .woocommerce-Tabs-panel--additional_information > h2, %%order_class%% .woocommerce-Reviews-title',
					'declaration' => "display:none !important;",
				) );
			}

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

			if ( '' !== $ul_type || '' !== $ul_position || '' !== $ul_item_indent ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% ul',
					'declaration' => sprintf(
						'%1$s
						%2$s
						%3$s',
						'' !== $ul_type ? sprintf( 'list-style-type: %1$s;', esc_html( $ul_type ) ) : '',
						'' !== $ul_position ? sprintf( 'list-style-position: %1$s;', esc_html( $ul_position ) ) : '',
						'' !== $ul_item_indent ? sprintf( 'padding-left: %1$s;', esc_html( $ul_item_indent ) ) : ''
					),
				) );
			}

			if ( '' !== $ol_type || '' !== $ol_position || '' !== $ol_item_indent ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% ol',
					'declaration' => sprintf(
						'%1$s
						%2$s
						%3$s',
						'' !== $ol_type ? sprintf( 'list-style-type: %1$s;', esc_html( $ol_type ) ) : '',
						'' !== $ol_position ? sprintf( 'list-style-position: %1$s;', esc_html( $ol_position ) ) : '',
						'' !== $ol_item_indent ? sprintf( 'padding-left: %1$s;', esc_html( $ol_item_indent ) ) : ''
					),
				) );
			}

			if ( '' !== $quote_border_weight || '' !== $quote_border_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% blockquote',
					'declaration' => sprintf(
						'%1$s
						%2$s',
						'' !== $quote_border_weight ? sprintf( 'border-width: %1$s;', esc_html( $quote_border_weight ) ) : '',
						'' !== $quote_border_color ? sprintf( 'border-color: %1$s;', esc_html( $quote_border_color ) ) : ''
					),
				) );
			}	

			$output = sprintf(
				'<div%2$s class="et_pb_woopro_tabs%3$s%4$s">
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

		if ( isset( $this->shortcode_atts['custom_button'] ) && $this->shortcode_atts['custom_button'] === 'on' ) {
			self::set_style( $function_name, array(
					'selector'    => '.woocommerce %%order_class%% #review_form #respond .form-submit input',
					'declaration' => $boxShadow->get_value( $this->shortcode_atts, array( 'suffix' => '_button' ) )
				)
			);
		}
	}
}
new ET_Builder_Module_WooPro_Tabs;
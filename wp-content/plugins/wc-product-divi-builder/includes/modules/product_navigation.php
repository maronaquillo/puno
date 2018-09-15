<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Navigation extends ET_Builder_Module {

	function init() {
		$this->name            = esc_html__( 'Woo Product Navigation', 'wc-product-divi-builder' );
		$this->slug            = 'et_pb_woopro_navigation';

		$this->whitelisted_fields = array(
			'nav_type',
			'link_next_text',
			'link_prev_text',
			'next_icon',
			'prev_icon',
			'icon_background',
			'icon_hover_background',

			'icon_font_size',
			'icon_font_size_tablet',
			'icon_font_size_phone',
			'icon_font_size_last_edited',

			'from_same_cat',
			'nav_text_orientation',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->options_toggles = array(

			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Navigation Options', 'wc-product-divi-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'icon_settings' => esc_html__( 'Icons Settings', 'wc-product-divi-builder' ),
				),
			),
		);

		$this->main_css_element = '%%order_class%%';

		$this->fields_defaults = array(
			'nav_type' 					=> array( 'thumbnails' ),
			'from_same_cat' 			=> array( 'off' ),
			'nav_text_orientation' 		=> array( 'center' ),
		);

		$this->advanced_options = array(
			'fonts' => array(
				'nav_links' => array(
					'label'    => esc_html__( 'Navigation', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} a",
					),
					'font_size' => array(
						'default' => '15px',
					),
				),
				'nav_links_on_hover' => array(
					'label'    => esc_html__( 'On Hover', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} a:hover",
					),
					'font_size' => array(
						'default' => '15px',
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
			'nav_links' => array(
				'label' => esc_html__( 'Navigation Links', 'wc-product-divi-builder' ),
				'selector' => "{$this->main_css_element} a",
			),
		);
	}

	function get_fields() {
		$fields = array(
			'nav_type' => array(
				'label' => esc_html__( 'Navigation Type', 'wc-product-divi-builder' ),
				'type' => 'select',
				'options_category' => 'basic_option',
				'options' => array( 
					'links'  		=> esc_html__( 'Links', 'wc-product-divi-builder' ),
					'icons' 		=> esc_html__( 'Icons', 'wc-product-divi-builder' ),
				),
				'affects' => array(
					'link_next_text',
					'link_prev_text',
					'next_icon',
					'prev_icon',
					'icon_background',
					'icon_hover_background',
					'icon_font_size',
				),
				'toggle_slug' => 'main_content',
			),
			'link_prev_text' => array(
				'label'       => esc_html__( 'Previous Product Text', 'wc-product-divi-builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'If you leave this empty, the product title will be used', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
				'depends_show_if' => 'links',
			),
			'link_next_text' => array(
				'label'       => esc_html__( 'Next Product Text', 'wc-product-divi-builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'If you leave this empty, the product title will be used', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
				'depends_show_if' => 'links',
			),
			'prev_icon' => array(
				'label'               => esc_html__( 'Previous Icon', 'wc-product-divi-builder' ),
				'type'                => 'text',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'toggle_slug'         => 'main_content',
				'depends_show_if'     => 'icons',
			),
			'next_icon' => array(
				'label'               => esc_html__( 'Next Icon', 'wc-product-divi-builder' ),
				'type'                => 'text',
				'option_category'     => 'basic_option',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'toggle_slug'         => 'main_content',
				'depends_show_if'     => 'icons',
			),
			'icon_font_size' => array(
				'label'           => esc_html__( 'Icons Font Size', 'et_builder' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'icon_settings',
				'default'         => '20px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1',
				),
				'mobile_options'  => true,
				'depends_default' => true,
				'depends_show_if'     => 'icons',
			),
			'icon_font_size_tablet' => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon_settings',
			),
			'icon_font_size_phone' => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon_settings',
			),
			'icon_font_size_last_edited' => array(
				'type'        => 'skip',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon_settings',
			),
			'icon_background' => array(
				'label' 			=> esc_html__( 'Icon Background', 'wc-product-divi-builder' ), 
				'type'        		=> 'color-alpha',
				'tab_slug'    		=> 'advanced',
				'toggle_slug' 		=> 'icon_settings',
				'depends_show_if'   => 'icons',
			),
			'icon_hover_background' => array(
				'label' 			=> esc_html__( 'Icon Hover Background', 'wc-product-divi-builder' ), 
				'type'        		=> 'color-alpha',
				'tab_slug'    		=> 'advanced',
				'toggle_slug' 		=> 'icon_settings',
				'depends_show_if'   => 'icons',
			),
			'from_same_cat' => array(
				'label'           => esc_html__( 'From The Same Category', 'wc-product-divi-builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option','options' => array( 
					'off' 		=> esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  		=> esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug' => 'main_content',
			),
			'nav_text_orientation' => array(
				'label'             => esc_html__( 'Nav Floating', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => array(
					'left' => esc_html__( 'left', 'wc-product-divi-builder' ),
					'right' => esc_html__( 'Right', 'wc-product-divi-builder' ),
					'center' => esc_html__( 'Center', 'wc-product-divi-builder' ),
					'edge_to_edge' => esc_html__( 'Edge to Edge', 'wc-product-divi-builder' ),
				),
				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'wc-product-divi-builder' ),
				'toggle_slug' => 'main_content',
				'default'	=> 'center',
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
		$nav_type 					= $this->shortcode_atts['nav_type'];
		$link_next_text 			= $this->shortcode_atts['link_next_text'];
		$link_prev_text 			= $this->shortcode_atts['link_prev_text'];

		$next_icon 					= $this->shortcode_atts['next_icon'];
		$prev_icon 					= $this->shortcode_atts['prev_icon'];

		$icon_background 			= $this->shortcode_atts['icon_background'];
		$icon_hover_background 		= $this->shortcode_atts['icon_hover_background'];
		
		$icon_font_size 			= $this->shortcode_atts['icon_font_size'];
		$icon_font_size_tablet 		= $this->shortcode_atts['icon_font_size_tablet'];
		$icon_font_size_phone  		= $this->shortcode_atts['icon_font_size_phone'];
		$icon_font_size_last_edited  = $this->shortcode_atts['icon_font_size_last_edited'];

		$from_same_cat 				= $this->shortcode_atts['from_same_cat'];
		
		$nav_text_orientation 		= $this->shortcode_atts['nav_text_orientation'];

		$module_id        			= $this->shortcode_atts['module_id'];
		$module_class     			= $this->shortcode_atts['module_class'];
		$module_class 				= ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if( function_exists( 'is_product' ) && is_product() ){
			
			$data = '';	
			$from_same_cat = $from_same_cat == 'on' ? true : false;	
			$nav_text_orientation = esc_attr( $nav_text_orientation );

			if( !empty( $nav_text_orientation ) ){
				$module_class .= " et_pb_text_align_{$nav_text_orientation}";
			}

			// links navigation
			if( $nav_type == 'links' ){

				$next_content = empty( $link_next_text ) ? '<span class="wcpb_nav_title">%title</span>' : esc_attr( $link_next_text );
				$prev_content = empty( $link_prev_text ) ? '<span class="wcpb_nav_title">%title</span>' : esc_attr( $link_prev_text );

			}

			// icons navigation
			if( $nav_type == 'icons' ){

				$module_class .= ' icons_nav';
				$font_size_responsive_active = et_pb_get_responsive_status( $icon_font_size_last_edited );

				$font_size_values = array(
					'desktop' => $icon_font_size,
					'tablet'  => $font_size_responsive_active ? $icon_font_size_tablet : '',
					'phone'   => $font_size_responsive_active ? $icon_font_size_phone : '',
				);

				et_pb_generate_responsive_css( $font_size_values, '%%order_class%% .et-pb-icon', 'font-size', $function_name );

				if( !empty( $icon_background ) ){

					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% a',
						'declaration' => "background: ". esc_attr( $icon_background ) .";",
					) );
				}

				if( !empty( $icon_hover_background ) ){

					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% a:hover',
						'declaration' => "background: ". esc_attr( $icon_hover_background ) .";",
					) );
				}

				// generating icons
				$prev_content = empty( $prev_icon ) ? '<span class="wcpb_nav_title">%title</span>' : "<span class='et-pb-icon'>" . esc_attr( et_pb_process_font_icon( $prev_icon ) ) . "</span>";
				$next_content = empty( $next_icon ) ? '<span class="wcpb_nav_title">%title</span>' : "<span class='et-pb-icon'>" . esc_attr( et_pb_process_font_icon( $next_icon ) ) . "</span>";

			}			

			// collecting data
			ob_start();
				?>

				<span class='wcpb_prev_product'>
					<?php previous_post_link( '%link', $prev_content, $from_same_cat, '', 'product_cat' ); ?>
				</span>

				<span class='wcpb_next_product'>
					<?php next_post_link( '%link', $next_content, $from_same_cat, '', 'product_cat' ); ?>
				</span>
				
				<?php
				$data = ob_get_contents();
			ob_end_clean();
		
			$output = sprintf(
				'<div%2$s class="et_pb_woopro_navigation et_pb_module%3$s">
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
new ET_Builder_Module_WooPro_Navigation;
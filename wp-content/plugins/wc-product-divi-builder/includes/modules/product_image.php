<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Image extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Product Image', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_image';

		$this->whitelisted_fields = array(
			'show_in_lightbox',
			'animation',
			'sticky',
			'align',
			'admin_label',
			'module_id',
			'module_class',
			'max_width',
			'force_fullwidth',
			'always_center_on_mobile',
			'use_overlay',
			'overlay_icon_color',
			'hover_overlay_color',
			'hover_icon',
			'max_width_tablet',
			'max_width_phone',
			'max_width_last_edited',
		);

		$animation_option_name = sprintf( '%1$s-animation', $this->slug );
		$global_animation_direction = ET_Global_Settings::get_value( $animation_option_name );
		$default_animation = $global_animation_direction && '' !== $global_animation_direction ? $global_animation_direction : 'left';

		$this->fields_defaults = array(
			'show_in_lightbox'        => array( 'off' ),
			'animation'               => array( $default_animation ),
			'sticky'                  => array( 'off' ),
			'align'                   => array( 'left' ),
			'force_fullwidth'         => array( 'off' ),
			'always_center_on_mobile' => array( 'on' ),
			'use_overlay'             => array( 'off' ),
		);

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Image', 'wc-product-divi-builder' ),
					'link'         => esc_html__( 'Link', 'wc-product-divi-builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'overlay'    => esc_html__( 'Overlay', 'wc-product-divi-builder' ),
					'alignment'  => esc_html__( 'Alignment', 'wc-product-divi-builder' ),
					'width'      => array(
						'title'    => esc_html__( 'Sizing', 'wc-product-divi-builder' ),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'wc-product-divi-builder' ),
						'priority' => 90,
					),
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', 'wc-product-divi-builder' ),
						'priority' => 95,
					),
				),
			),
		);

		$this->advanced_options = array(
			'border'                => array(),
			'custom_margin_padding' => array(
				'use_padding' => false,
				'css' => array(
					'important' => 'all',
				),
			),
		);
	}

	function get_fields() {
		// List of animation options
		$animation_options_list = array(
			'left'    => esc_html__( 'Left To Right', 'wc-product-divi-builder' ),
			'right'   => esc_html__( 'Right To Left', 'wc-product-divi-builder' ),
			'top'     => esc_html__( 'Top To Bottom', 'wc-product-divi-builder' ),
			'bottom'  => esc_html__( 'Bottom To Top', 'wc-product-divi-builder' ),
			'fade_in' => esc_html__( 'Fade In', 'wc-product-divi-builder' ),
			'off'     => esc_html__( 'No Animation', 'wc-product-divi-builder' ),
		);

		$animation_option_name       = sprintf( '%1$s-animation', $this->slug );
		$default_animation_direction = ET_Global_Settings::get_value( $animation_option_name );

		// If user modifies default animation option via Customizer, we'll need to change the order
		if ( 'left' !== $default_animation_direction && ! empty( $default_animation_direction ) && array_key_exists( $default_animation_direction, $animation_options_list ) ) {
			// The options, sans user's preferred direction
			$animation_options_wo_default = $animation_options_list;
			unset( $animation_options_wo_default[ $default_animation_direction ] );

			// All animation options
			$animation_options = array_merge(
				array( $default_animation_direction => $animation_options_list[$default_animation_direction] ),
				$animation_options_wo_default
			);
		} else {
			// Simply copy the animation options
			$animation_options = $animation_options_list;
		}

		$fields = array(
			'show_in_lightbox' => array(
				'label'             => esc_html__( 'Open in Lightbox', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( "No", 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'affects'           => array(
					'use_overlay'
				),
				'toggle_slug'       => 'link',
				'description'       => esc_html__( 'Here you can choose whether or not the image should open in Lightbox.', 'wc-product-divi-builder' ),
			),
			'use_overlay' => array(
				'label'             => esc_html__( 'Image Overlay', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'off' => esc_html__( 'Off', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'On', 'wc-product-divi-builder' ),
				),
				'affects'           => array(
					'overlay_icon_color',
					'hover_overlay_color',
					'hover_icon',
				),
				'depends_default'   => true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
				'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'wc-product-divi-builder' ),
			),
			'overlay_icon_color' => array(
				'label'             => esc_html__( 'Overlay Icon Color', 'wc-product-divi-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
				'description'       => esc_html__( 'Here you can define a custom color for the overlay icon', 'wc-product-divi-builder' ),
			),
			'hover_overlay_color' => array(
				'label'             => esc_html__( 'Hover Overlay Color', 'wc-product-divi-builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
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
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'overlay',
				'description'       => esc_html__( 'Here you can define a custom icon for the overlay', 'wc-product-divi-builder' ),
			),
			'animation' => array(
				'label'             => esc_html__( 'Animation', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => $animation_options,
				'tab_slug'          => 'custom_css',
				'toggle_slug'       => 'animation',
				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'wc-product-divi-builder' ),
			),
			'sticky' => array(
				'label'             => esc_html__( 'Remove Space Below The Image', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'off'     => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'      => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'alignment',
				'description'       => esc_html__( 'Here you can choose whether or not the image should have a space below it.', 'wc-product-divi-builder' ),
			),
			'align' => array(
				'label'           => esc_html__( 'Image Alignment', 'wc-product-divi-builder' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options' => array(
					'left'   => esc_html__( 'Left', 'wc-product-divi-builder' ),
					'center' => esc_html__( 'Center', 'wc-product-divi-builder' ),
					'right'  => esc_html__( 'Right', 'wc-product-divi-builder' ),
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'alignment',
				'description'       => esc_html__( 'Here you can choose the image alignment.', 'wc-product-divi-builder' ),
			),
			'max_width' => array(
				'label'           => esc_html__( 'Image Max Width', 'wc-product-divi-builder' ),
				'type'            => 'text',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'width',
				'mobile_options'  => true,
				'validate_unit'   => true,
			),
			'max_width_last_edited' => array(
				'type'     => 'skip',
				'tab_slug' => 'advanced',
			),
			'force_fullwidth' => array(
				'label'             => esc_html__( 'Force Fullwidth', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'off' => esc_html__( "No", 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'width',
			),
			'always_center_on_mobile' => array(
				'label'             => esc_html__( 'Always Center Image On Mobile', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( "No", 'wc-product-divi-builder' ),
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'alignment',
			),
			'max_width_tablet' => array(
				'type'     => 'skip',
				'tab_slug' => 'advanced',
			),
			'max_width_phone' => array(
				'type'     => 'skip',
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
		$module_id               = $this->shortcode_atts['module_id'];
		$module_class            = $this->shortcode_atts['module_class'];
		$animation               = $this->shortcode_atts['animation'];
		$show_in_lightbox        = $this->shortcode_atts['show_in_lightbox'];
		$sticky                  = $this->shortcode_atts['sticky'];
		$align                   = $this->shortcode_atts['align'];
		$max_width               = $this->shortcode_atts['max_width'];
		$max_width_tablet        = $this->shortcode_atts['max_width_tablet'];
		$max_width_phone         = $this->shortcode_atts['max_width_phone'];
		$max_width_last_edited   = $this->shortcode_atts['max_width_last_edited'];
		$force_fullwidth         = $this->shortcode_atts['force_fullwidth'];
		$always_center_on_mobile = $this->shortcode_atts['always_center_on_mobile'];
		$overlay_icon_color      = $this->shortcode_atts['overlay_icon_color'];
		$hover_overlay_color     = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon              = $this->shortcode_atts['hover_icon'];
		$use_overlay             = $this->shortcode_atts['use_overlay'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if( function_exists( 'is_product' ) && is_product() ){
			
			$alt = $title_text = get_the_title();
			
			if( has_post_thumbnail() ){
				$src = get_the_post_thumbnail_url();
			}else{
				$src = esc_url( wc_placeholder_img_src() );
			}
		}else{
			return '';
		}

		if ( 'on' === $always_center_on_mobile ) {
			$module_class .= ' et_always_center_on_mobile';
		}

		// overlay can be applied only if image has link or if lightbox enabled
		$is_overlay_applied = 'on' === $use_overlay && 'on' === $show_in_lightbox ? 'on' : 'off';

		if ( '' !== $max_width_tablet || '' !== $max_width_phone || '' !== $max_width ) {
			$max_width_responsive_active = et_pb_get_responsive_status( $max_width_last_edited );

			$max_width_values = array(
				'desktop' => $max_width,
				'tablet'  => $max_width_responsive_active ? $max_width_tablet : '',
				'phone'   => $max_width_responsive_active ? $max_width_phone : '',
			);

			et_pb_generate_responsive_css( $max_width_values, '%%order_class%%', 'max-width', $function_name );
		}

		if ( 'on' === $force_fullwidth ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% img',
				'declaration' => 'width: 100%;',
			) );
		}

		if ( $this->fields_defaults['align'][0] !== $align ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'text-align: %1$s;',
					esc_html( $align )
				),
			) );
		}

		if ( 'center' !== $align ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'margin-%1$s: 0;',
					esc_html( $align )
				),
			) );
		}

		if ( 'on' === $is_overlay_applied ) {
			if ( '' !== $overlay_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $overlay_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}

			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$overlay_output = sprintf(
				'<span class="et_overlay%1$s"%2$s></span>',
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);
		}

		$output = sprintf(
			'<img src="%1$s" alt="%2$s"%3$s />
			%4$s',
			esc_url( $src ),
			esc_attr( $alt ),
			( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
			'on' === $is_overlay_applied ? $overlay_output : ''
		);

		if ( 'on' === $show_in_lightbox ) {
			$output = sprintf( '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
				esc_url( $src ),
				$output,
				esc_attr( $alt )
			);
		}

		$animation = '' === $animation ? ET_Global_Settings::get_value( 'et_pb_image-animation' ) : $animation;

		$output = sprintf(
			'<div%5$s class="et_pb_module et-waypoint et_pb_image%2$s%3$s%4$s%6$s">
				%1$s
			</div>',
			$output,
			esc_attr( " et_pb_animation_{$animation}" ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			( 'on' === $sticky ? esc_attr( ' et_pb_image_sticky' ) : '' ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			'on' === $is_overlay_applied ? ' et_pb_has_overlay' : ''
		);

		return $output;
	}
}
new ET_Builder_Module_WooPro_Image;
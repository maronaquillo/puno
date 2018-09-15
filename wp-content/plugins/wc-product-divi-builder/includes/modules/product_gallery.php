<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class ET_Builder_Module_WooPro_Gallery extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Woo Product Gallery', 'wc-product-divi-builder' );
		$this->slug       = 'et_pb_woopro_gallery';

		$this->whitelisted_fields = array(
			'inc_pro_img',
			'gallery_ids',
			'gallery_orderby',
			'fullwidth',
			'posts_number',
			'show_title_and_caption',
			'show_pagination',
			'background_layout',
			'auto',
			'auto_speed',
			'admin_label',
			'module_id',
			'module_class',
			'zoom_icon_color',
			'hover_overlay_color',
			'hover_icon',
			'orientation',
		);

		$this->fields_defaults = array(
			'inc_pro_img'			 => array( 'off' ),
			'fullwidth'              => array( 'off' ),
			'posts_number'           => array( 4, 'add_default_setting' ),
			'show_title_and_caption' => array( 'on' ),
			'show_pagination'        => array( 'on' ),
			'background_layout'      => array( 'light' ),
			'auto'                   => array( 'off' ),
			'auto_speed'             => array( '7000' ),
			'orientation'            => array( 'landscape' ),
		);

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Images', 'et_builder' ),
					'elements'     => esc_html__( 'Elements', 'et_builder' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout'  => esc_html__( 'Layout', 'et_builder' ),
					'overlay' => esc_html__( 'Overlay', 'et_builder' ),
					'text'    => array(
						'title'    => esc_html__( 'Text', 'et_builder' ),
						'priority' => 49,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'et_builder' ),
						'priority' => 90,
					),
				),
			),
		);		

		$this->main_css_element = '%%order_class%%.et_pb_gallery';
		$this->advanced_options = array(
			'fonts' => array(
				'caption' => array(
					'label'    => esc_html__( 'Caption', 'wc-product-divi-builder' ),
					'use_all_caps' => true,
					'css'      => array(
						'main' => "{$this->main_css_element} .mfp-title, {$this->main_css_element} .et_pb_gallery_caption",
					),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					'depends_show_if'   => 'off'
				),
				'title'   => array(
					'label'    => esc_html__( 'Title', 'wc-product-divi-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .et_pb_gallery_title",
					),
				),
			),
			'border' => array(
				'css' => array(
					'main' => "{$this->main_css_element} .et_pb_gallery_item",
				),
			),
		);

		$this->custom_css_options = array(
			'gallery_item' => array(
				'label'    => esc_html__( 'Gallery Item', 'wc-product-divi-builder' ),
				'selector' => '.et_pb_gallery_item',
			),
			'overlay' => array(
				'label'    => esc_html__( 'Overlay', 'wc-product-divi-builder' ),
				'selector' => '.et_overlay',
			),
			'overlay_icon' => array(
				'label'    => esc_html__( 'Overlay Icon', 'wc-product-divi-builder' ),
				'selector' => '.et_overlay:before',
			),
			'gallery_item_title' => array(
				'label'    => esc_html__( 'Gallery Item Title', 'wc-product-divi-builder' ),
				'selector' => '.et_pb_gallery_title',
			),
			'gallery_item_caption' => array(
				'label'    => esc_html__( 'Gallery Item Caption', 'wc-product-divi-builder' ),
				'selector' => '.et_pb_gallery_caption',
			),
			'gallery_pagination' => array(
				'label'    => esc_html__( 'Gallery Pagination', 'wc-product-divi-builder' ),
				'selector' => '.et_pb_gallery_pagination',
			),
			'gallery_pagination_active' => array(
				'label'    => esc_html__( 'Pagination Active Page', 'wc-product-divi-builder' ),
				'selector' => '.et_pb_gallery_pagination a.active',
			),
		);
	}

	function get_fields() {
		$fields = array(
			'inc_pro_img' => array(
				'label' => esc_html__( 'Include Product Image', 'wc-product-divi-builder' ),
				'description' => esc_html__( 'If you enable this, product image will be added to the gallery', 'wc-product-divi-builder' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
				),
				'toggle_slug'     => 'main_content',
			),
			'gallery_ids' => array(
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
				'computed_affects'   => array(
					'__gallery',
				),
			),
			'gallery_orderby' => array(
				'label' => esc_html__( 'Gallery Images', 'wc-product-divi-builder' ),
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
				'computed_affects'   => array(
					'__gallery',
				),
				'toggle_slug'     => 'main_content',
			),
			'fullwidth' => array(
				'label'             => esc_html__( 'Layout', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => array(
					'off' => esc_html__( 'Grid', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'Slider', 'wc-product-divi-builder' ),
				),
				'description'       => esc_html__( 'Toggle between the various blog layout types.', 'wc-product-divi-builder' ),
				'affects'           => array(
					'zoom_icon_color',
					'caption_font',
					'caption_text_color',
					'caption_line_height',
					'caption_font_size',
					'caption_all_caps',
					'caption_letter_spacing',
					'hover_overlay_color',
					'auto',
					'posts_number',
					'show_title_and_caption',
					'orientation'
				),
				'computed_affects'   => array(
					'__gallery',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Images Number', 'wc-product-divi-builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'wc-product-divi-builder' ),
				'depends_show_if'   => 'off',
				'toggle_slug'       => 'main_content',
			),
			'orientation'            => array(
				'label'              => esc_html__( 'Thumbnail Orientation', 'wc-product-divi-builder' ),
				'type'               => 'select',
				'options_category'   => 'configuration',
				'options'            => array(
					'landscape' => esc_html__( 'Landscape', 'wc-product-divi-builder' ),
					'portrait'  => esc_html__( 'Portrait', 'wc-product-divi-builder' )
				),
				'description'        => sprintf(
					'%1$s<br><small><em><strong>%2$s:</strong> %3$s <a href="//wordpress.org/plugins/force-regenerate-thumbnails" target="_blank">%4$s</a>.</em></small>',
					esc_html__( 'Choose the orientation of the gallery thumbnails.', 'wc-product-divi-builder' ),
					esc_html__( 'Note', 'wc-product-divi-builder' ),
					esc_html__( 'If this option appears to have no effect, you might need to', 'wc-product-divi-builder' ),
					esc_html__( 'regenerate your thumbnails', 'wc-product-divi-builder')
				),
				'depends_show_if'    => 'off',
				'computed_affects'   => array(
					'__gallery',
				),
				'tab_slug'           => 'advanced',
				'toggle_slug'        => 'layout',
			),
			'show_title_and_caption' => array(
				'label'              => esc_html__( 'Show Title and Caption', 'wc-product-divi-builder' ),
				'type'               => 'yes_no_button',
				'option_category'    => 'configuration',
				'options'            => array(
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'description'        => esc_html__( 'Whether or not to show the title and caption for images (if available).', 'wc-product-divi-builder' ),
				'depends_show_if'    => 'off',
				'toggle_slug'        => 'elements',
			),
			'show_pagination' => array(
				'label'             => esc_html__( 'Show Pagination', 'wc-product-divi-builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'wc-product-divi-builder' ),
					'off' => esc_html__( 'No', 'wc-product-divi-builder' ),
				),
				'toggle_slug'        => 'elements',
				'description'        => esc_html__( 'Enable or disable pagination for this feed.', 'wc-product-divi-builder' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Color', 'wc-product-divi-builder' ),
				'type'              => 'select',
				'option_category'   => 'color_option',
				'options'           => array(
					'light'  => esc_html__( 'Dark', 'wc-product-divi-builder' ),
					'dark' => esc_html__( 'Light', 'wc-product-divi-builder' ),
				),
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'text',
				'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'wc-product-divi-builder' ),
			),
			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'wc-product-divi-builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'Off', 'wc-product-divi-builder' ),
					'on'  => esc_html__( 'On', 'wc-product-divi-builder' ),
				),
				'affects' => array(
					'auto_speed',
				),
				'depends_show_if'   => 'on',
				'depends_to'        => array(
					'fullwidth',
				),
				'tab_slug'          => 'custom_css',
				'toggle_slug'       => 'animation',
				'description'       => esc_html__( 'If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'wc-product-divi-builder' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'wc-product-divi-builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'depends_default'   => true,
				'tab_slug'          => 'custom_css',
				'toggle_slug'       => 'animation',
				'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'wc-product-divi-builder' ),
			),
			'zoom_icon_color' => array(
				'label'             => esc_html__( 'Hover Icon Color', 'wc-product-divi-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'depends_show_if'   => 'off',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
			),
			'hover_overlay_color' => array(
				'label'             => esc_html__( 'Hover Overlay Color', 'wc-product-divi-builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'depends_show_if'   => 'off',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'overlay',
			),
			'hover_icon' => array(
				'label'               => esc_html__( 'Hover Icon Picker', 'wc-product-divi-builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => true,
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'overlay',
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
			'__gallery' => array(
				'type' => 'computed',
				'computed_callback' => array( 'ET_Builder_Module_Gallery', 'get_gallery' ),
				'computed_depends_on' => array(
					'gallery_ids',
					'gallery_orderby',
					'fullwidth',
					'orientation',
				),
			),
		);

		return $fields;
	}

	/**
	 * Get attachment data for gallery module
	 *
	 * @param array $args {
	 *     Gallery Options
	 *
	 *     @type array  $gallery_ids     Attachment Ids of images to be included in gallery.
	 *     @type string $gallery_orderby `orderby` arg for query. Optional.
	 *     @type string $fullwidth       on|off to determine grid / slider layout
	 *     @type string $orientation     Orientation of thumbnails (landscape|portrait).
	 * }
	 * @param array $conditional_tags
	 * @param array $current_page
	 *
	 * @return array Attachments data
	 */
	static function get_gallery( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		$attachments = array();

		$defaults = array(
			'gallery_ids'     => array(),
			'gallery_orderby' => '',
			'fullwidth'       => 'off',
			'orientation'     => 'landscape',
		);

		$args = wp_parse_args( $args, $defaults );

		$attachments_args = array(
			'include'        => $args['gallery_ids'],
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'post__in',
		);

		if ( 'rand' === $args['gallery_orderby'] ) {
			$attachments_args['orderby'] = 'rand';
		}

		if ( 'on' === $args['fullwidth'] ) {
			$width  = 1080;
			$height = 9999;
		} else {
			$width  =  400;
			$height = ( 'landscape' === $args['orientation'] ) ? 284 : 516;
		}

		$width  = (int) apply_filters( 'et_pb_gallery_image_width', $width );
		$height = (int) apply_filters( 'et_pb_gallery_image_height', $height );

		$_attachments = get_posts( $attachments_args );

		foreach ( $_attachments as $key => $val ) {
			$attachments[$key] = $_attachments[$key];
			$attachments[$key]->image_src_full  = wp_get_attachment_image_src( $val->ID, 'full' );
			$attachments[$key]->image_src_thumb = wp_get_attachment_image_src( $val->ID, array( $width, $height ) );
		}

		return $attachments;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$inc_pro_img			= $this->shortcode_atts['inc_pro_img'];
		$module_id              = $this->shortcode_atts['module_id'];
		$module_class           = $this->shortcode_atts['module_class'];
		$fullwidth              = $this->shortcode_atts['fullwidth'];
		$show_title_and_caption = $this->shortcode_atts['show_title_and_caption'];
		$background_layout      = $this->shortcode_atts['background_layout'];
		$posts_number           = $this->shortcode_atts['posts_number'];
		$show_pagination        = $this->shortcode_atts['show_pagination'];
		$gallery_orderby        = $this->shortcode_atts['gallery_orderby'];
		$zoom_icon_color        = $this->shortcode_atts['zoom_icon_color'];
		$hover_overlay_color    = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon             = $this->shortcode_atts['hover_icon'];
		$auto                   = $this->shortcode_atts['auto'];
		$auto_speed             = $this->shortcode_atts['auto_speed'];
		$orientation            = $this->shortcode_atts['orientation'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		
		if( function_exists( 'is_product' ) && is_product() ){
			global $product;
			if( version_compare( WC()->version, '3.0.0', '>=' ) ){
				$attachment_ids = $product->get_gallery_image_ids();
			}else{
				$attachment_ids = $product->get_gallery_attachment_ids();
			}

			if( $inc_pro_img == 'on' && has_post_thumbnail() ){

				$attachment_ids[] = get_post_thumbnail_id();
			}

			if( empty( $attachment_ids ) ){
				return '';
			}

			$gallery_ids = implode(',', $attachment_ids);
		}else{
			return '';
		}

		if ( '' !== $zoom_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $zoom_icon_color )
				),
			) );
		}

		if ( '' !== $hover_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $hover_overlay_color )
				),
			) );
		}

		// Get gallery item data
		$attachments = self::get_gallery( array(
			'gallery_ids'     => $gallery_ids,
			'gallery_orderby' => $gallery_orderby,
			'fullwidth'       => $fullwidth,
			'orientation'     => $orientation,
		) );

		if ( empty( $attachments ) ) {
			return '';
		}

		wp_enqueue_script( 'hashchange' );

		$fullwidth_class = 'on' === $fullwidth ?  ' et_pb_slider et_pb_gallery_fullwidth' : ' et_pb_gallery_grid';
		$background_class = " et_pb_bg_layout_{$background_layout}";

		$module_class .= 'on' === $auto && 'on' === $fullwidth ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';

		$posts_number = 0 === intval( $posts_number ) ? 4 : intval( $posts_number );

		$output = sprintf(
			'<div%1$s class="et_pb_module et_pb_woopro_gallery et_pb_gallery%2$s%3$s%4$s clearfix">
				<div class="et_pb_gallery_items et_post_gallery clearfix" data-per_page="%5$d">',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
			esc_attr( $fullwidth_class ),
			esc_attr( $background_class ),
			esc_attr( $posts_number )
		);

		foreach ( $attachments as $id => $attachment ) {
			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$image_output = sprintf(
				'<a href="%1$s" title="%2$s">
					<img src="%3$s" alt="%2$s" />
					<span class="et_overlay%4$s"%5$s></span>
				</a>',
				esc_url( $attachment->image_src_full[0] ),
				esc_attr( $attachment->post_title ),
				esc_url( $attachment->image_src_thumb[0] ),
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);

			$output .= sprintf(
				'<div class="et_pb_gallery_item%2$s%1$s">',
				esc_attr( $background_class ),
				( 'on' !== $fullwidth ? ' et_pb_grid_item' : '' )
			);
			$output .= "
				<div class='et_pb_gallery_image {$orientation}'>
					$image_output
				</div>";

			if ( 'on' !== $fullwidth && 'on' === $show_title_and_caption ) {
				if ( trim($attachment->post_title) ) {
					$output .= "
						<h3 class='et_pb_gallery_title'>
						" . wptexturize($attachment->post_title) . "
						</h3>";
				}
				if ( trim($attachment->post_excerpt) ) {
				$output .= "
						<p class='et_pb_gallery_caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</p>";
				}
			}
			$output .= "</div>";
		}

		$output .= "</div><!-- .et_pb_gallery_items -->";

		if ( 'on' !== $fullwidth && 'on' === $show_pagination ) {
			$output .= "<div class='et_pb_gallery_pagination'></div>";
		}

		$output .= "</div><!-- .et_pb_gallery -->";

		return $output;
	}
}
new ET_Builder_Module_WooPro_Gallery;
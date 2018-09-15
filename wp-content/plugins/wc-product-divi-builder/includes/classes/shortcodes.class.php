<?php

if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

if( !class_exists( 'WCPB_ShortCodes' ) ){

	class WCPB_ShortCodes{

		public function __construct(){

			add_shortcode( 'wcpb_shortcode', array( $this, 'shortcode_type' ) );

		}

		public function shortcode_type( $atts ){

			global $post, $product;

			if( $post->post_type !== 'product' || is_admin() ){
				return;
			}

			$atts = shortcode_atts( 
				array(

					'type' 				=> '',
					'gallery_columns' 	=> 3,
					'size'				=> 'thumbnail',
					'link'				=> 'file',
					'lightbox'			=> 'yes',
					'heading'			=> 'yes',

				), 
				$atts );

			$func = $output = '';

			switch ( $atts['type'] ) {

				case 'title':
					$output = get_the_title();
					break;

				case 'meta':
					$func = 'woocommerce_template_single_meta';
					break;

				case 'slider':
					ob_start();
					do_action( 'woocommerce_before_single_product_summary' );
					$output = ob_get_contents();
					ob_end_clean();
					break;	

				case 'rating':
					$func = 'woocommerce_template_single_rating';
					break;

				case 'add_to_cart':
					$func = 'woocommerce_template_single_add_to_cart';
					break;

				case 'description':
					$hide_heaing = isset( $atts['heading'] ) && $atts['heading'] == 'no' ? ' hide_heading' : '';
					ob_start();
					echo "<div class='wcpb_shortcode{$hide_heaing}'>";
					woocommerce_product_description_tab();
					echo "</div>";
					$output = ob_get_clean();
					break;
				
				case 'excerpt':
					$func = 'woocommerce_template_single_excerpt';
					break;

				case 'additional_info':

					$hide_heaing = isset( $atts['heading'] ) && $atts['heading'] == 'no' ? ' hide_heading' : '';
					ob_start();
					echo "<div class='wcpb_shortcode{$hide_heaing}'>";
					woocommerce_product_additional_information_tab();
					echo "</div>";
					$output = ob_get_clean();
					break;	
					
				case 'reviews':

					$hide_heaing = isset( $atts['heading'] ) && $atts['heading'] == 'no' ? ' hide_heading' : '';
					ob_start();
					echo "<div class='wcpb_shortcode{$hide_heaing}'>";
					comments_template();
					echo "</div>";
					$output = ob_get_clean();
					break;		

				case 'price':
					$func = 'woocommerce_template_single_price';
					break;

				case 'related':

					$hide_heaing = isset( $atts['heading'] ) && $atts['heading'] == 'no' ? ' hide_heading' : '';
					ob_start();
					echo "<div class='wcpb_shortcode{$hide_heaing}'>";
					woocommerce_output_related_products();
					echo "</div>";
					$output = ob_get_clean();
					break;		

				case 'upsells':

					$hide_heaing = isset( $atts['heading'] ) && $atts['heading'] == 'no' ? ' hide_heading' : '';
					ob_start();
					echo "<div class='wcpb_shortcode{$hide_heaing}'>";
					woocommerce_upsell_display();
					echo "</div>";
					$output = ob_get_clean();
					break;	

				case 'image':
			
					$alt = $title_text = get_the_title();
					
					if( has_post_thumbnail() ){
						$src = get_the_post_thumbnail_url();
					}else{
						$src = esc_url( wc_placeholder_img_src() );
					}

					$output = "<img src='{$src}' alt='{$alt}' title='{$title_text}'>";
					break;

				case 'gallery':
					if( version_compare( WC()->version, '3.0.0', '>=' ) ){
						$attachment_ids = $product->get_gallery_image_ids();
					}else{
						$attachment_ids = $product->get_gallery_attachment_ids();
					}

					if( count( $attachment_ids ) ){

						$gallery_ids = implode(',', $attachment_ids);

						if( is_numeric( $atts['gallery_columns'] ) ){
							$gallery_columns = $atts['gallery_columns'];
						}else{
							$gallery_columns = 3;
						}

						$size 		= esc_attr( $atts['size'] );
						$link 		= esc_attr( $atts['link'] );
						$lightbox 	= esc_attr( $atts['lightbox'] );

						$class = '';
						if( $lightbox == 'yes' ){
							$class = ' lightbox';
						}

						$output = "<div class='wcpb_gallery_shortcode et_post_gallery{$class}'>" . do_shortcode( '[gallery ids="'. $gallery_ids .'" columns="'. $gallery_columns .'" link="'.$link.'" size="'. $size .'"]' ) . "</div>";

					}
					break;
			}

			if( $func ){

				$output = WC_ET_BUILDER::content_buffer( $func );

			}

			if( $output ){
				return $output;
			}
			
		}

	}

	$wcpb_shortcodes = new WCPB_ShortCodes();
}


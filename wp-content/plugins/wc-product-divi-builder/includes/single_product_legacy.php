<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.3.2 => WCPB
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// get page divi template
$product_divi_template = WC_ET_BUILDER::get_single_product_layout_id( get_the_ID() );

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
				/**
				 * woocommerce_before_single_product hook.
				 *
				 * @hooked wc_print_notices - 10
				 */
				 do_action( 'woocommerce_before_single_product' );

				 if ( post_password_required() ) {
				 	echo get_the_password_form();
				 	return;
				 }
			?>						
			<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php 
					// product schema data
					if( class_exists( 'WC_Structured_Data' ) ){
						$wc_str_data = new WC_Structured_Data();
					 	$wc_str_data->generate_product_data();					
					}
				?>
				<?php WC_ET_BUILDER::get_divi_layout_content( $product_divi_template ); ?>

			</div><!-- #product-<?php the_ID(); ?> -->

			<?php do_action( 'woocommerce_after_single_product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>

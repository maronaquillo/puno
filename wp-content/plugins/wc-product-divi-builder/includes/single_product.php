<?php 
	
/**
* @since 1.4.0
*/

?>


<?php get_header('shop'); ?>


<?php

	$product_divi_template = WC_ET_BUILDER::get_single_product_layout_id( get_the_ID() ); 

?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
		 do_action( 'woocommerce_before_single_product' );

		 if ( post_password_required() ) {
		 	echo get_the_password_form();
		 	return;
		 }
	?>					
	<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php 
				// product schema data
				if( class_exists( 'WC_Structured_Data' ) ){
					$wc_str_data = new WC_Structured_Data();
				 	$wc_str_data->generate_product_data();					
				}
			?>
			<?php
				// get the layout content 
				WC_ET_BUILDER::get_divi_layout_content( $product_divi_template ); 
			?>
		</div><!-- /.entry-content -->
	</div> <!-- #product- -->					
	<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php endwhile; ?>
				
<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer('shop'); ?>
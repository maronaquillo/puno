<?php 
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class WC_ET_BUILDER_METABOX{

	public function __construct(){

		// don't show this metabox if divi or woocommerce is not active or the current user can't manage woocommerce
		if( ! WC_ET_BUILDER::is_woo_active() || ! WC_ET_BUILDER::is_divi_active() ){
			return;
		}
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post_product', array( $this, 'save_product_layout_metabox' ) );

	}

	// add choose layout metabox
	function add_metabox(){
		add_meta_box( 'woo_divi_produc_layout', DIVI_PRO_PL_NAME, array( $this, 'woo_divi_product_layout_cb' ), 'product', 'side', 'high' );
	}

	// metabox callback
	public function woo_divi_product_layout_cb( $post ){

		$layouts 			= WC_ET_BUILDER::get_all_divi_layouts();
		$this_post_layout 	= WC_ET_BUILDER::get_single_product_layout_id( $post->ID );
		
		wp_nonce_field( 'single_product_layout_nonce', 'single_product_layout_nonce' );
		?>	
			<div>
				<p>
					<label for="single_product_divi_layout">
						<span class="dashicons dashicons-editor-kitchensink"></span> 
						<b>Choose Product Divi Layout:</b>
					</label>
				</p>
				<select name="single_product_divi_layout" id="single_product_divi_layout">
					<option value="0"><?php echo 'Default WooCommerce Layout'; ?></option>
					<?php
						if( count( $layouts ) ){
							foreach( $layouts as $layout ){
								$selected = $this_post_layout == $layout['id'] ? 'selected' : '';
								echo "<option value='{$layout['id']}' {$selected}>{$layout['name']}</option>";
							}
						}
					?>
				</select>
				<p class="description">This layout will override the default layout set on <a href="<?php echo esc_url( admin_url( 'options-general.php?page=wc-product-divi-builder' ) ); ?>" target="_blank">plugin settings page</a></p>
			</div>

			<div id="wpdb_pro_cover_img">
				<?php
					$product_cover_img_url = get_post_meta( $post->ID, '_product_cover_img_url', true );
				?>
				<p>
					<span class="dashicons dashicons-format-image"></span>
					<b>Product Cover Image:</b>
				</p>
				<p id="product_cover_image_container">
					<?php 
						$hide_remove_class = 'hidden';
						$hide_upload_class = 'hidden';

						if( $product_cover_img_url ){
							$hide_remove_class = '';
							echo '<img src="'. esc_attr( $product_cover_img_url ) .'" alt="" style="max-width: 100%">';
						}else{
							$hide_upload_class = '';
						} 
					?>
				</p>
				<a href="#" id="remove_cover_img" class="<?php echo $hide_remove_class; ?>">Remove this image</a>
				<a href="#" id="upload_cover_img_btn" class="<?php echo $hide_upload_class; ?> button">Choose/Upload an image</a>
				<input type="hidden" id="product_cover_img_url" name="product_cover_img_url" value="<?php echo esc_attr( $product_cover_img_url ); ?>">
				<p class="description">This image will be used by product cover module as a background</p>
			</div>
		<?php
	}	

	// save metabox
	function save_product_layout_metabox( $post_id ){
		$is_valid_nonce = ( isset( $_POST['single_product_layout_nonce'] ) && wp_verify_nonce( $_POST['single_product_layout_nonce'], 'single_product_layout_nonce' ) ) ? true : false;
		$is_user_can 	= ( current_user_can( 'edit_post', $post_id ) ) ? true : false;

		if( !$is_valid_nonce || !$is_user_can ){
			return;
		}

		// update layout
		$new_layout = is_numeric( $_POST['single_product_divi_layout'] ) ? $_POST['single_product_divi_layout'] : 0 ;
		update_post_meta( $post_id, DIVI_PRO_LAYOUT_KEY, $new_layout );

		// update cover image
		$cover_img_url = !empty( $_POST['product_cover_img_url'] ) ? esc_url( $_POST['product_cover_img_url'] ) : '';
		update_post_meta( $post_id, '_product_cover_img_url', $cover_img_url );
	}

}

new WC_ET_BUILDER_METABOX();
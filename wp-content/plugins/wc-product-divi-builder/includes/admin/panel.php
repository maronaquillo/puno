<?php if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly ?>
<div class="wrap">
	<h1>
		<span class="dashicons dashicons-cart"></span>
		<?php
			echo DIVI_PRO_PL_NAME . ' Settings';
		?>
	</h1>
	
	<!-- Setttings Navigation Start -->
	<nav class="nav-tab-wrapper">
	    <?php $active_tab = !empty( $_GET['tab'] ) ? esc_html( $_GET['tab'] ) : 'general'; ?>
		<a href="?page=wc-product-divi-builder&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General Settings', 'wc-product-divi-builder' ); ?></a>
		<a href="?page=wc-product-divi-builder&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Shortcodes', 'wc-product-divi-builder' ); ?></a>
		<a href="?page=wc-product-divi-builder&tab=updates" class="nav-tab <?php echo $active_tab == 'updates' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Updates', 'wc-product-divi-builder' ); ?></a>
	</nav>
	<!-- Setttings Navigation End -->

	<form action="options.php" method="post">
		
		<table class="form-table wcpb_admin_table">
			<tbody>
				
				<?php 

					if( $active_tab == 'general' ){ 

						WC_ET_BUILDER::woo_divi_are_required_notice();
						settings_fields( 'divi_woo_settings' );
						$layouts = WC_ET_BUILDER::get_all_divi_layouts();
						$saved_settings = WC_ET_BUILDER_SETTINGS::plugin_settings();

				?>		
						<tr>
							<th colspan="2">
								<h2 class="title"><?php esc_html_e( 'Product Layout', 'wc-product-divi-builder' ); ?></h2>
							</th>
						</tr>

						<tr>
							<th scope="row">
								<label for="default_product_layout"><?php esc_html_e( 'Default Product Page Layout', 'wc-product-divi-builder' ); ?></label>
							</th>
							<td>
								<select name="divi_woo_settings[default_product_layout]" id="default_product_layout">
									<option value="0"><?php esc_html_e( 'Default WooCommerce Layout', 'wc-product-divi-builder' ); ?></option>
									<?php
										if( count( $layouts ) ){
											foreach( $layouts as $layout ){
												$selected = $layout['id'] == $saved_settings['default_product_layout'] ? 'selected' : '';
												echo "<option value='{$layout['id']}' {$selected}>{$layout['name']}</option>";
											}
										}
									?>
								</select>
								<p class="description">
									<?php esc_html_e( 'This layout can be overridden for individual products in product editing page', 'wc-product-divi-builder' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="enable_divi_for_product_page">
									<?php esc_html_e( 'Enable Divi Builder For Product Description', 'wc-product-divi-builder' ); ?>
								</label>
							</th>
							<td>
								<label>
								<input type="checkbox" name="divi_woo_settings[enable_divi_for_product_page]" id="enable_divi_for_product_page" value="1" <?php checked( 1, $saved_settings['enable_divi_for_product_page'], true ) ?> /><?php esc_html_e('Enable', 'wc-product-divi-builder'); ?>
								</label>
								<p class="description">
									<?php esc_html_e( 'This will enable the use of Divi builder in product editing page', 'wc-product-divi-builder' ); ?>
								</p>
								<div style="margin-top: 20px">
									<label>
									<input type="checkbox" name="divi_woo_settings[use_saved_layouts_for_product]" id="use_saved_layouts_for_product" value="1" <?php checked( 1, $saved_settings['use_saved_layouts_for_product'], true ) ?> /><?php esc_html_e('Use Divi Library For Description Builder', 'wc-product-divi-builder'); ?>
									</label>
									<p class="description">
										<?php esc_html_e( 'By default, each custom post type has its own layouts library, enable this to use all saved layouts in the description builder.', 'wc-product-divi-builder' ); ?>
									</p>	
								</div>
							</td>
						</tr>

						<tr>
							<th colspan="2">
								<hr>
								<h2 class="title"><?php esc_html_e( 'Display', 'wc-product-divi-builder' ); ?></h2>
							</th>
						</tr>
						
						<tr>
							<th scope="row">
								<label for="fullwidth_row_fix">
									<?php esc_html_e( 'Make Fullwidth Rows 100% width', 'wc-product-divi-builder' ); ?>
								</label>
							</th>
							<td>
								<label>
									<input type="checkbox" name="divi_woo_settings[fullwidth_row_fix]" id="fullwidth_row_fix" value="1" <?php checked( 1, $saved_settings['fullwidth_row_fix'], true ) ?> /><?php esc_html_e('Enable', 'wc-product-divi-builder'); ?>
								</label>
								<p class="description">
									<?php esc_html_e( 'By default, when you make a row full-width in Divi Builder, it\'ll be 80% width only. This option affects product pages only.', 'wc-product-divi-builder' ); ?>
								</p>
							</td>
						</tr>

						<tr><td colspan="2"><?php submit_button(); ?></td></tr>
						
				<?php } // end if general tab ?>

				<?php 

					if( $active_tab == 'shortcodes' ){

				?>
						<tr>
							<th scope="row">
								<label><?php esc_html_e( 'How to use', 'wc-product-divi-builder' ); ?></label>
							</th>
							<td>
								<p>Using shortcodes will enable you to use product page parts like product description, excerpt, title, image ... inside any other pre-defined Divi modules like toggle, tabs and even sliders.</p>

								<p>Copy & paste any of these shortcodes inside any content area of Divi modules.</p>

								<h3>List of all shortcodes</h3>
								<ol>
									<li><b>[wcpb_shortcode type="title"]</b></li>
									<p class="description">For product title.</p>

									<li><b>[wcpb_shortcode type="description" heading="yes"]</b></li>
									<p class="description">
										For product description. 
										<b><span class="red_text">NEVER use this inside product description or short description area.</span></b>
										<p><b>- heading:</b> yes/no. Yes is the default, if "no", the heading title will be removed.</p>
									</p>

									<li><b>[wcpb_shortcode type="excerpt"]</b></li>
									<p class="description">
										For product excerpt.
										<b><span class="red_text">NEVER use this inside product description or short description area.</span></b>
									</p>

									<li><b>[wcpb_shortcode type="price"]</b></li>
									<p class="description">For product price.</p>

									<li><b>[wcpb_shortcode type="rating"]</b></li>
									<p class="description">For product rating.</p>

									<li><b>[wcpb_shortcode type="add_to_cart"]</b></li>
									<p class="description">For quantity and add to cart button</p>

									<li><b>[wcpb_shortcode type="additional_info" heading="yes"]</b></li>
									<p class="description">For product additional information/attributes.
										<p><b>- heading:</b> yes/no. Yes is the default, if "no", the heading title will be removed.</p>
									</p>

									<li><b>[wcpb_shortcode type="reviews" heading="yes"]</b></li>
									<p class="description">For product reviews.
										<p><b>- heading:</b> yes/no. Yes is the default, if "no", the heading title will be removed.</p>
									</p>

									<li><b>[wcpb_shortcode type="related" heading="yes"]</b></li>
									<p class="description">For related products.
										<p><b>- heading:</b> yes/no. Yes is the default, if "no", the heading title will be removed.</p>
									</p>

									<li><b>[wcpb_shortcode type="upsells" heading="yes"]</b></li>
									<p class="description">For product upsells.
										<p><b>- heading:</b> yes/no. Yes is the default, if "no", the heading title will be removed.</p>
									</p>

									<li><b>[wcpb_shortcode type="image"]</b></li>
									<p class="description">For product featured image.</p>
 
									<li><b>[wcpb_shortcode type="gallery" gallery_columns="4" lightbox="yes" link="file" size="thumbnail"]</b></li>
									<p class="description">
										For product gallery. 
										<p>- <b>gallery_columns:</b> Change columns number as you want</p>
										<p>- <b>lightbox:</b> yes/no. yes is the default to enable lightbox</p>
										<p>- <b>link:</b> file/none. link the image to the file url or none, if you enabled lightbox, this must be file.</p>
										<p>- <b>size:</b> thumbnail/medium/large. Image size, thumbnail is the default</p>
									</p>

									<li><b>[wcpb_shortcode type="slider"]</b></li>
									<p class="description">For product images slider.</p>

									<li><b>[wcpb_shortcode type="meta"]</b></li>
									<p class="description">For product categories, tags and SKU.</p>
								</ol>

							</td>
						</tr>
				<?php 

					} // end if shortcodes tab 

				?>

				<?php 

					if( $active_tab == 'updates' ){

						settings_fields( 'wcpb_license_key' );
						$wcpb_license_key = get_option( 'wcpb_license_key' ); 

				?>
						<tr>
							<th scope="row">
								<label for="wcpb_license_key"><?php esc_html_e( 'License Key', 'wc-product-divi-builder' ); ?></label>
							</th>
							<td>
								<input type="text" name="wcpb_license_key" class="regular-text" id="wcpb_license_key" value="<?php echo esc_attr( $wcpb_license_key ); ?>">
								<p class="description">
									<?php _e( 'Enter your license key to receive updates, get it from <a href="https://www.divikingdom.com/my-account/orders/" target="_blank">Orders under My Account page.', 'wc-product-divi-builder' ); ?>
								</p>
							</td>
						</tr>
						<tr><td colspan="2"><?php submit_button(); ?></td></tr>
				<?php 

					} // end if updates tab 

				?>

			</tbody>
		</table><!-- /.form-table -->
	</form>
	
	<div class="postbox wcbp_admin_section" style="padding: 10px">
		<p><b>Thank you for using my plugin, if you think this plugin is useful, please consider reviewing it with 5 stars <a href="https://www.divikingdom.com/product/woocommerce-product-builder/#reviews" target="_blank">Here</a>.</b></p>

		<p><b>Also if you need help, please open a support ticket <a href="https://www.divikingdom.com/customer-support/" target="_blank">Here</a>.</b></p>
	</div><!-- /.wcbp_admin_section -->

</div><!-- /.wrap -->
<?php wp_reset_postdata(); ?>
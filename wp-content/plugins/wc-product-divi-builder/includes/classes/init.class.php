<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class WC_ET_BUILDER{

	protected static $required_item = array();

	public function __construct(){

		// on plugin activation
		register_activation_hook( DIVI_PRO_PL_PATH . 'index.php', array( $this, 'on_plugin_activation' ) );

		// show notice on plugin activation
		if( get_transient( 'divi_woo_required_transient' ) ){
			add_action( 'admin_notices', array( $this, 'woo_divi_are_required_notice' ) );
			delete_transient( 'divi_woo_required_transient' );
		}

		// load text domain
		add_action( 'init', array( $this, 'load_text_domain' ) );

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_load_scripts' ) );

		// load my single product template instead of default WooCommerce's one
		if( self::is_woo_active() && self::is_divi_active() ){
			add_filter( 'template_include', array( $this, 'new_single_product_template' ), 99 );
		}

		add_filter( 'body_class', array( $this, 'fix_body_classes' ), 9999 );

		// load WooCommerce modules
		add_filter( 'et_pb_templates_loading_amount', function(){ return 57; } );
		$this->load_woo_modules();
	}

	// check for divi theme, Extra theme, or a child of any of them is used
	public static function is_divi_active(){

		$curr_theme 	= wp_get_theme();

		$parent_theme 	= strtolower( $curr_theme->Name );
		$child_theme 	= strtolower( $curr_theme->Template );

		if( $parent_theme == 'divi' || $parent_theme == 'extra' || $child_theme == 'divi' || $child_theme == 'extra' ){
			return true;
		}else{
			return false;
		}

	}

	// check if WooCommerce is active
	public static function is_woo_active(){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if( is_plugin_active( 'woocommerce/woocommerce.php' ) ){
			return true;
		}else{
			return false;
		}
	}

	// notice output to show after plugin activation and in plugin settings page
	// about Divi and WooCommerce are required
	public static function woo_divi_are_required_notice(){
		if( ! self::is_divi_active() ){
			self::$required_item[] = '<b><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=38335&tid1=pro_builder" target="_blank">Divi or Extra Theme</a></b>';
		}

		if( ! self::is_woo_active() ){
			self::$required_item[] = '<b><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a></b>';
		}

		if( count( self::$required_item ) ){
			$message = '<b>' . DIVI_PRO_PL_NAME . '</b> requires ' . implode( ' & ', self::$required_item ) . ' to be active to work!';
			?>
				<div class="notice notice-warning">
					<p>
						<?php echo $message; ?>
					</p>
				</div><!-- /.notice -->
			<?php
		}
	}

	// what will happen on plugin activation
	public function on_plugin_activation(){

		// set transient for a notice about Divi and WooCommerce to be shown once on activation
		set_transient( 'divi_woo_required_transient', true, 1 );
	}

	// load plugin text domain
	public function load_text_domain(){
		load_plugin_textdomain( 'wc-product-divi-builder', false, 'wc-product-divi-builder/languages/' );
	}

	// load modules
	public function load_woo_modules(){
		
		if( self::is_divi_active() && self::is_woo_active() ){
			add_action( 'et_builder_ready', array( $this, 'get_woo_divi_modules' ) );
		}else{
			return;
		}

	}

	// include WooCommerce Custom Modules and Clear Cache
	public function get_woo_divi_modules(){
		// get modules
		require_once DIVI_PRO_PL_PATH . 'includes/modules/index.php';
		// clear modules cache
		add_action( 'admin_head', array( $this, 'clear_modules_cache' ), 999 );
	}

	// clear modules cache
	public function clear_modules_cache(){
		
	?>
	
		<script>
			var ET_Prefix = 'et_pb_templates_et_pb_woopro_';
			// all my modules
			var myModules = [ 

				ET_Prefix + 'title',
				ET_Prefix + 'breadcrumb',
				ET_Prefix + 'image',
				ET_Prefix + 'gallery',
				ET_Prefix + 'rating',
				ET_Prefix + 'price',
				ET_Prefix + 'excerpt',
				ET_Prefix + 'add_to_cart',
				ET_Prefix + 'meta',
				ET_Prefix + 'tabs',
				ET_Prefix + 'upsells',
				ET_Prefix + 'related_products',
				ET_Prefix + 'description',
				ET_Prefix + 'additional_info',
				ET_Prefix + 'reviews',
				ET_Prefix + 'summary',
				ET_Prefix + 'images_slider',
				ET_Prefix + 'cover',
				ET_Prefix + 'notices',
				ET_Prefix + 'navigation'

			]; // array of all modules created by this plugin

			for(var module in localStorage){
				if(myModules.indexOf(module) != -1){
					localStorage.removeItem(module);
				}
			}
		</script>

	<?php

	}

	// my new single product page template
	public function new_single_product_template( $template ){

		// Ps: if visual builder is enabled, load the WooCommerce default Layout
		if( is_product() && empty( $_GET['et_fb'] ) ){

			$layout_id = self::get_single_product_layout_id( get_the_ID() );

			if( $layout_id !== 0 ){

				// add some classes to the body
				self::add_body_classes();

				// some cleaning for items that have their own modules and the page marckup
				remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
				remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

				remove_action( 'woocommerce_before_main_content', 'et_divi_output_content_wrapper', 10 );
				remove_action( 'woocommerce_after_main_content', 'et_divi_output_content_wrapper_end', 10 );

				remove_action( 'woocommerce_before_main_content', 'extra_woocommerce_output_content_wrapper', 10 );
				remove_action( 'woocommerce_after_main_content', 'extra_woocommerce_output_content_wrapper_end', 10 );

				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
				remove_action( 'woocommerce_before_single_product', 'wc_print_notices' );

				// add the page html wrapper
				add_action( 'woocommerce_before_main_content', 'wcpb_woocommerce_output_content_wrapper', 10 );
				add_action( 'woocommerce_after_main_content', 'wcpb_woocommerce_output_content_wrapper_end', 10 );

				// add the fullwidth row CSS
				if( WC_ET_BUILDER_SETTINGS::plugin_settings()['fullwidth_row_fix'] == 1 ){
					add_action( 'wp_head', function(){
						?>
						<style>
							.woo_product_divi_layout .et_pb_row.et_pb_row_fullwidth, 
							.woo_product_divi_layout .et_pb_specialty_fullwidth > .et_pb_row {
							    width: 100% !important;
							    max-width: 100% !important;
							}
						</style>
						<?php
					}, 999 );
				}

				// change the single product template to mine
				$template = DIVI_PRO_PL_PATH .'includes/single_product.php';
			}
			
		}
		return $template;
	}

	// load front end scripts
	public function load_scripts(){
		
		if( function_exists( 'is_product' ) && is_product() ){

			wp_enqueue_style( 'woo-pro-divi-style', DIVI_PRO_PL_URL . 'includes/frontend/css/style.css' );
			
			wp_enqueue_script( 'woo-pro-divi-js', DIVI_PRO_PL_URL . 'includes/frontend/js/custom.js', array( 'jquery' ), false, true );

		}
	}

	// load back end scripts
	public function admin_load_scripts(){
		wp_enqueue_script( 'woo-pro-divi-admin-js', DIVI_PRO_PL_URL . 'includes/admin/js/main.admin.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'woo-pro-divi-admin-css', DIVI_PRO_PL_URL . 'includes/admin/css/style.admin.css' );
	}

	// get array of all divi layouts
	public static function get_all_divi_layouts( $return_ids = false ){

		// get all divi layouts
		$query_args = array(
			'meta_query'      => array(
				array(
					'key'     => '_et_pb_predefined_layout',
					'value'   => 'on',
					'compare' => 'NOT EXISTS',
				),
			),
			'post_type'       => 'et_pb_layout',
			'posts_per_page'  => '-1'
		);

		$layouts_query = get_posts( $query_args );

		$layouts = array();

		if( $layouts_query ){

			foreach( $layouts_query as $layout ){
				$layouts[] = array(
					'id' 	=> esc_attr( $layout->ID ),
					'name' 	=> esc_attr( $layout->post_title )
				);
			}

		}

		if( $return_ids == true ){
				
			$layouts_ids = array();
			
			if( count( $layouts ) ){
				foreach( $layouts as $layout ){
					$layouts_ids[] = $layout['id'];
				}
			}

			return $layouts_ids;
		}else{
			return $layouts;
		}		
	}

	// get single product layout id
	public static function get_single_product_layout_id( $product_id ){

		$saved_settings = WC_ET_BUILDER_SETTINGS::plugin_settings();

		$this_post_layout = get_post_meta( $product_id, DIVI_PRO_LAYOUT_KEY, true );
		
		// if no special layout for this specific post, set it to the default
		if( $this_post_layout === '' ){
			$this_post_layout = $saved_settings['default_product_layout'];
		}

		// check if this layout already exists, if not - may be the user deleted the layout - set it to 0
		$all_layouts = self::get_all_divi_layouts( true ); // true to get an array of layouts IDs

		if( !in_array( $this_post_layout, $all_layouts ) ){
			$this_post_layout = 0;
		}
		return $this_post_layout;
	}	

	// add single product body classes
	public static function add_body_classes(){

		function sailor_body_classes( $classes ){
			$classes[] = 'woo_product_divi_layout';
			$classes[] = 'et_pb_pagebuilder_layout';

			// remove sidebar classes
			$x = 0;
			foreach( $classes as $class ){
				if( $class == 'et_right_sidebar' ) unset( $classes[$x] );
				if( $class == 'et_left_sidebar' ) unset( $classes[$x] );
				$x++;
			}
			return $classes;
		}
		
		add_filter( 'body_class', 'sailor_body_classes' );	

	}

	// get layout content
	public static function get_divi_layout_content( $layout_id ){
		if( ! $layout_id ){
			return;
		}
		
		if( $layout = get_post( $layout_id ) ){

			if( isset( ET_Builder_Element::$can_reset_shortcode_indexes ) ){
				ET_Builder_Element::$can_reset_shortcode_indexes = false;
				echo do_shortcode( et_pb_fix_shortcodes( wpautop( $layout->post_content ) ) );
				ET_Builder_Element::$can_reset_shortcode_indexes = true;
				ET_Builder_Element::reset_shortcode_indexes();				
			}else{
				echo do_shortcode( et_pb_fix_shortcodes( wpautop( $layout->post_content ) ) );
			}
		}
	}

	// buffering woocommerce functions
	public static function content_buffer( $func ){

		$output = '';
		if( function_exists( $func ) ){
			ob_start();
			$func();
			$output = ob_get_contents();
			ob_end_clean();		
		}
		return $output;

	}	

	// render ET font icons content css property
	public static function et_icon_css_content( $font_icon ){
		$icon = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );

		return '\\' . $icon;
	}	

	// fix body class
	public function fix_body_classes( $classes ){
		/**
		* et_pb_pagebuilder_layout class will be added to the product page if the builder is enabled for the decription
		* and the builder is not used but the page layout settings is selected to be fullwidth
		* which will make the page 100% width with no margings at all.

		* Remove this class in case there is no layout chosen from the right top box
		*/
		if( function_exists( 'is_product' ) && is_product() ){
			$x = 0;

			if( !in_array( 'woo_product_divi_layout', $classes ) ){
				foreach( $classes as $class ){
					if( $class == 'et_pb_pagebuilder_layout' ){
						unset( $classes[$x] );
					}
					$x++;
				}				
			}

		}

		return $classes;
	}	

}

new WC_ET_BUILDER();
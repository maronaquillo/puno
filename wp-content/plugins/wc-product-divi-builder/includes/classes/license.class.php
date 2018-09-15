<?php

if( !class_exists( 'WCPB_License' ) ){

	class WCPB_License{

		public 	$api_url,
				$www,
				$slug,
				$plugin,
				$current_version,
				$license_key,
				$instance,
				$result = array();

		public function __construct(){

			// plugin info
			$this->api_url 			= 'https://www.divikingdom.com/index.php';
			$this->www 				= 'https://www.divikingdom.com';
			$this->slug 			= 'WCPB';
			$this->plugin 			= 'wc-product-divi-builder/index.php';
			$this->current_version 	= '1.4.0';
			$this->license_key 		= get_option( 'wcpb_license_key' );
			$protocol 				= (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$this->instance 		= str_replace( $protocol, "", get_bloginfo('wpurl'));


			add_filter('pre_set_site_transient_update_plugins', array($this, 'check_for_plugin_update'));
			add_filter('plugins_api', array($this, 'plugins_api_call'), 20, 3);

		}

		public function activate( $input_key ){

			$input_key = esc_html( $input_key );

			if( empty( $input_key ) ){

				$this->result['status'] 	= false;
            	$this->result['message'] 	= 'Please enter a valid license key!';

            	return $this->result;
			}

			$args = array(
			    'woo_sl_action'         => 'activate',
			    'licence_key'       	=> $input_key,
			    'product_unique_id'     => $this->slug,
			    'domain'          		=> $this->instance
			);
			$request_uri    = $this->api_url . '?' . http_build_query( $args );
			$data           = wp_remote_get( $request_uri );

			if(is_wp_error( $data ) || $data['response']['code'] != 200){

			    $this->result['status'] 	= false;
            	$this->result['message'] 	= "There was a problem activating the license key! Please try again later or open a support ticket <a href='{$this->www}/customer-support/' target='_blank'>here</a>.";

            	return $this->result;
			}

			$data_body = json_decode($data['body']);
			$data_body = $data_body[0];

			if(isset($data_body->status)){

		        if(($data_body->status == 'success' && $data_body->status_code == 's100') || ($data_body->status == 'error' && $data_body->status_code == 'e113')){
	                
	                //the license is active and the software is active
	                //doing further actions like saving the license and allow the plugin to run
	                
	                $this->result['status'] 	= true;
                	$this->result['message'] 	= "Great! The license is active.";

	            }else{
	                //there was a problem activating the license

	                $this->result['status'] 	= false;
                	$this->result['message'] 	= "Invalid license key! You can manage your license on your orders page <a href='{$this->www}/my-account/orders/' target='_blank'>here</a>.";
	            }

		    }else{
		        //there was a problem establishing a connection to the API server

		        $this->result['status'] 	= false;
            	$this->result['message'] 	= "There was a problem activating the license key! Please try again later or open a support ticket <a href='{$this->www}/customer-support/' target='_blank'>here</a>.";
		    }

		    return $this->result;			

		}

		public function check_for_plugin_update($checked_data){

			if ( ! empty( $checked_data->response ) && ! empty( $checked_data->response[$this->plugin]) ){

				return $checked_data;
			}

			global $pagenow;
			if ( 'plugins.php' == $pagenow && is_multisite() ) {
				return $checked_data;
			}

			$request_string = $this->prepare_request('plugin_update');
			if($request_string === FALSE)
				return $checked_data;

			// Start checking for an update
			$request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
			$data = wp_remote_get( $request_uri );

			if(is_wp_error( $data ) || $data['response']['code'] != 200)
				return $checked_data;

			$response_block = json_decode($data['body']);

			if(!is_array($response_block) || count($response_block) < 1){
			    return $checked_data;
			}
			//retrieve the last message within the $response_block
			$response_block = $response_block[count($response_block) - 1];
			$response = isset($response_block->message) ? $response_block->message : '';

			if (is_object($response) && !empty($response)) // Feed the update data into WP updater
			{
				//include slug and plugin data
				$response->slug = $this->slug;
				$response->plugin = $this->plugin;

				$checked_data->response[$this->plugin] = $response;
			}

			return $checked_data;
		}

		public function plugins_api_call($def, $action, $args){
			if (!is_object($args) || !isset($args->slug) || $args->slug != $this->slug)
				return false;

			//$args->package_type = $this->package_type;

			$request_string = $this->prepare_request($action, $args);
			if($request_string === FALSE)
				return new WP_Error('plugins_api_failed', __('An error occour when try to identify the plugin.' , 'apto') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'apto' ) .'&lt;/a>');;

			$request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
			$data = wp_remote_get( $request_uri );

			if(is_wp_error( $data ) || $data['response']['code'] != 200)
				return new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.' , 'apto') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'apto' ) .'&lt;/a>', $data->get_error_message());

			$response_block = json_decode($data['body']);
			//retrieve the last message within the $response_block
			$response_block = $response_block[count($response_block) - 1];
			$response = $response_block->message;

			if (is_object($response) && !empty($response)) // Feed the update data into WP updater
			{
				//include slug and plugin data
				$response->slug = $this->slug;
				$response->plugin = $this->plugin;

				$response->sections = (array)$response->sections;
				$response->banners = (array)$response->banners;

				return $response;
			}
		}		

		public function prepare_request($action, $args = array()){

			global $wp_version;

			return array(
				'woo_sl_action' 	=> $action,
				'version' 			=> $this->current_version,
				'product_unique_id' => $this->slug,
				'licence_key' 		=> $this->license_key,
				'domain' 			=> $this->instance,
				'wp-version' 		=> $wp_version,

			);
		}		

	}

}

// initiate the class
function sailor_wcpb_run_updater(){

	if( !is_admin() ){
		return;
	}
	
	if( !isset( $GLOBALS['wcpb_license'] ) ){
		$GLOBALS['wcpb_license'] = new WCPB_License();
	}
	
	return $GLOBALS['wcpb_license'];
}

add_action( 'after_setup_theme', 'sailor_wcpb_run_updater' );
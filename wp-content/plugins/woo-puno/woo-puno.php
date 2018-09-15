<?php 

/**
 * Plugin Name: Woo Puno
 * Plugin URI: https://puno.ph/
 * Description: A woocommerce extension for Unionbank EON payment integration
 * Version: 1.0
 * Author: Maron Aquillo
 * Author URI: https://maronaquillo.com
 * Text Domain: woocommerce
 * Domain Path: /i18n/languages/
 *
 * @package WooPuno
 */

function init() {

    class WC_Gateway_Puno extends WC_Payment_Gateway {
        
        function __construct() {
            
            $this->id = 'woopuno';
            $this->icon = 'https://www.unionbankph.com/images/icons/unionbankonline.jpg';
            $this->has_fields = true;
            $this->method_title = "Unionbank EON";
            $this->method_description = "Take payments Visa/Mastercard. Most widely used when purchasing online.";
            $this->supports = array( 'default_credit_card_form' );

            $this->form_fields = array(
                'title' => array(
                    'title' => __( 'Title', 'woocommerce' ),
                    'type' => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                    'default' => __( 'Unionbank EON', 'woocommerce' ),
                    'desc_tip'      => true,
                ),

                'client_id' => array(
                    'title' => __( 'Client ID', 'woocommerce' ),
                    'type' => 'text',
                ),

                'client_secret' => array(
                    'title' => __( 'Client Secret', 'woocommerce' ),
                    'type' => 'text',
                ),

                'redirect_uri' => array(
                    'title' => __( 'Redirect URI', 'woocommerce' ),
                    'type' => 'text',
                ),
            );

            $this->init_form_fields();
            $this->init_settings();

            $this->title = $this->get_option( 'title' );

            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

        }

        function process_payment( $order_id ) {

            global $woocommerce;
            $order = new WC_Order( $order_id );
        
            if ( !$order->payment_complete() ) {

                wc_add_notice( __('Payment error:', 'woothemes') . $error_message, 'error' );
                return;
            }
            // Return thankyou redirect
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url( $order )
            );
        }

       
        function validate_fields() {
            return true;
        }

    }
}

function puno_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Puno'; 
    return $methods;
}

add_filter( 'woocommerce_payment_gateways', 'puno_gateway_class' );
add_action( 'plugins_loaded', 'init' );


<?php
/**
 * Plugin Name: Woocommmerce Misc Fee
 * Description: Add a 1% fee for american express during checkout
 * Author: thesquatchman
 * Version: 0.9
 *
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */


 
 /**
 * Add a 1% surcharge to your cart / checkout
 * change the $percentage to set the surcharge to a value to suit
 * Uses the WooCommerce fees API
 *
 */
wp_enqueue_script('woo-misc-fee', plugin_dir_url( __FILE__ ) . '/misc-fee.js', array('jquery'));
 
add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge' );
function woocommerce_custom_surcharge() {
  if ( is_admin() && ! defined( 'DOING_AJAX' ) || ! $_POST  )  return;

  global $woocommerce;	

	$percentage = 0.01;
	$surcharge = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;
	if (isset($_POST['post_data']) && strpos($_POST['post_data'], 'amex')) :
 
		$woocommerce->cart->add_fee( 'Amex Surcharge', $surcharge, true, '' );
  endif;
}

/**
 * Add the field to the checkout
 */
add_action( 'woocommerce_checkout_fields', 'wp_squatch_amex_custom_checkout_field' );

function wp_squatch_amex_custom_checkout_field( $fields ) {
    $fields['billing']['billing_amex'] = array(
    'label'     => __('Paying with an American Express Card', 'woocommerce'),
    'type' => 'checkbox',
    'required'  => false,
    'class'     => array('input-checkbox'),
    'clear'     => true
     );

     return $fields;
}
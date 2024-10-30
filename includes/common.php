<?php
/**
*
* Filename: common.php
* Description: common.php loads commonly accessed functions across the Visser Labs suite.
*
* - jigo_get_action
* - jigo_is_wpsc_activated
* - jigo_is_woo_activated
* - jigo_is_jigo_activated
*
*/

if( is_admin() ) {

	/* Start of: WordPress Administration */

	include_once( JIGO_CE_PATH . 'includes/common-dashboard_widgets.php' );

	/* End of: WordPress Administration */

}

if( !function_exists( 'jigo_get_action' ) ) {
	function jigo_get_action( $switch = false ) {

		if( $switch ) {

			if( isset( $_GET['action'] ) )
				$action = $_GET['action'];
			else if( !isset( $action ) && isset( $_POST['action'] ) )
				$action = $_POST['action'];
			else
				$action = false;

		} else {

			if( isset( $_POST['action'] ) )
				$action = $_POST['action'];
			else if( !isset( $action ) && isset( $_GET['action'] ) )
				$action = $_GET['action'];
			else
				$action = false;

		}
		return $action;

	}
}

if( !function_exists( 'jigo_is_wpsc_activated' ) ) {
	function jigo_is_wpsc_activated() {

		if( class_exists( 'WP_eCommerce' ) || defined( 'WPSC_VERSION' ) )
			return true;

	}
}

if( !function_exists( 'jigo_is_woo_activated' ) ) {
	function jigo_is_woo_activated() {

		if( class_exists( 'Woocommerce' ) )
			return true;

	}
}

if( !function_exists( 'jigo_is_jigo_activated' ) ) {
	function jigo_is_jigo_activated() {

		if( function_exists( 'jigoshop_init' ) )
			return true;

	}
}
?>
<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	// HTML template for disabled Filter Customers by Order Status widget on Store Exporter screen
	function jigo_ce_customers_filter_by_status() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$order_statuses = jigo_ce_get_order_statuses();

		ob_start(); ?>
<p><label><input type="checkbox" id="customers-filters-status" /> <?php _e( 'Filter Customers by Order Status', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-customers-filters-status" class="separator">
	<ul>
<?php foreach( $order_statuses as $order_status ) { ?>
		<li><label><input type="checkbox" name="customer_filter_status[<?php echo $order_status->name; ?>]" value="<?php echo $order_status->name; ?>" disabled="disabled" /> <?php echo ucfirst( $order_status->name ); ?></label></li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Order Status you want to filter exported Customers by. Default is to include all Order Status options.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-customers-filters-status -->
<?php
		ob_end_flush();

	}

	/* End of: WordPress Administration */

}

// Returns a list of Customer export columns
function jigo_ce_get_customer_fields( $format = 'full' ) {

	$export_type = 'customer';

	$fields = array();
	$fields[] = array(
		'name' => 'user_id',
		'label' => __( 'User ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'user_name',
		'label' => __( 'Username', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'user_role',
		'label' => __( 'User Role', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_full_name',
		'label' => __( 'Billing: Full Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_first_name',
		'label' => __( 'Billing: First Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_last_name',
		'label' => __( 'Billing: Last Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_company',
		'label' => __( 'Billing: Company', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_address',
		'label' => __( 'Billing: Street Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_city',
		'label' => __( 'Billing: City', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_postcode',
		'label' => __( 'Billing: ZIP Code', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_state',
		'label' => __( 'Billing: State', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_country',
		'label' => __( 'Billing: Country', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_phone',
		'label' => __( 'Billing: Phone Number', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_email',
		'label' => __( 'Billing: E-mail Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_full_name',
		'label' => __( 'Shipping: Full Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_first_name',
		'label' => __( 'Shipping: First Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_last_name',
		'label' => __( 'Shipping: Last Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_company',
		'label' => __( 'Shipping: Company', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_address',
		'label' => __( 'Shipping: Street Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_city',
		'label' => __( 'Shipping: City', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_postcode',
		'label' => __( 'Shipping: ZIP Code', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_state',
		'label' => __( 'Shipping: State', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_country',
		'label' => __( 'Shipping: Country', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'total_spent',
		'label' => __( 'Total Spent', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'completed_orders',
		'label' => __( 'Completed Orders', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'total_orders',
		'label' => __( 'Total Orders', 'jigo_ce' )
	);

/*
	$fields[] = array(
		'name' => '',
		'label' => __( '', 'jigo_ce' )
	);
*/

	// Allow Plugin/Theme authors to add support for additional columns
	$fields = apply_filters( 'jigo_ce_' . $export_type . '_fields', $fields, $export_type );

	switch( $format ) {

		case 'summary':
			$output = array();
			$size = count( $fields );
			for( $i = 0; $i < $size; $i++ ) {
				if( isset( $fields[$i] ) )
					$output[$fields[$i]['name']] = 'on';
			}
			return $output;
			break;

		case 'full':
		default:
			$sorting = jigo_ce_get_option( $export_type . '_sorting', array() );
			$size = count( $fields );
			for( $i = 0; $i < $size; $i++ ) {
				$fields[$i]['reset'] = $i;
				$fields[$i]['order'] = ( isset( $sorting[$fields[$i]['name']] ) ? $sorting[$fields[$i]['name']] : $i );
			}
			// Check if we are using PHP 5.3 and above
			if( version_compare( phpversion(), '5.3' ) >= 0 )
				usort( $fields, jigo_ce_sort_fields( 'order' ) );
			return $fields;
			break;

	}

}
?>
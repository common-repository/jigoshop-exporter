<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	// HTML template for disabled Coupon Sorting widget on Store Exporter screen
	function jigo_ce_coupon_sorting() {

		ob_start(); ?>
<p><label><?php _e( 'Coupon Sorting', 'jigo_ce' ); ?></label></p>
<div>
	<select name="coupon_orderby" disabled="disabled">
		<option value="ID"><?php _e( 'Coupon ID', 'jigo_ce' ); ?></option>
		<option value="title"><?php _e( 'Coupon Code', 'jigo_ce' ); ?></option>
		<option value="date"><?php _e( 'Date Created', 'jigo_ce' ); ?></option>
		<option value="modified"><?php _e( 'Date Modified', 'jigo_ce' ); ?></option>
		<option value="rand"><?php _e( 'Random', 'jigo_ce' ); ?></option>
	</select>
	<select name="coupon_order" disabled="disabled">
		<option value="ASC"><?php _e( 'Ascending', 'jigo_ce' ); ?></option>
		<option value="DESC"><?php _e( 'Descending', 'jigo_ce' ); ?></option>
	</select>
	<p class="description"><?php _e( 'Select the sorting of Coupons within the exported file. By default this is set to export Coupons by Coupon ID in Desending order.', 'jigo_ce' ); ?></p>
</div>
<?php
		ob_end_flush();

	}

	/* End of: WordPress Administration */

}

// Returns a list of Coupon export columns
function jigo_ce_get_coupon_fields( $format = 'full' ) {

	$export_type = 'coupon';

	$fields = array();
	$fields[] = array(
		'name' => 'coupon_code',
		'label' => __( 'Coupon Code', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'coupon_type',
		'label' => __( 'Coupon Type', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'coupon_amount',
		'label' => __( 'Coupon Amount', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'product_ids',
		'label' => __( 'Product ID\'s', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'from',
		'label' => __( 'From', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'to',
		'label' => __( 'To', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'alone',
		'label' => __( 'Alone', 'jigo_ce' )
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
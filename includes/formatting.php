<?php
function jigo_ce_file_encoding( $content = '' ) {

	global $export;

	if( function_exists( 'mb_convert_encoding' ) ) {
		$to_encoding = $export->encoding;
		$from_encoding = 'auto';
		if( !empty( $to_encoding ) )
			$content = mb_convert_encoding( trim( $content ), $to_encoding, $from_encoding );
		if( $to_encoding == 'UTF-8' )
			$content = utf8_decode( $content );
	}
	return $content;

}

// Format the raw memory data provided by PHP
function jigo_ce_display_memory( $memory = 0 ) {

	$output = '-';
	if( !empty( $output ) )
		$output = sprintf( __( '%s MB', 'jigo_ce' ), $memory );
	echo $output;

}

// Format the raw timestamps to something more friendly
function jigo_ce_display_time_elapsed( $from, $to ) {

	$output = __( '1 second', 'jigo_ce' );
	$time = $to - $from;
	$tokens = array (
		31536000 => __( 'year', 'jigo_ce' ),
		2592000 => __( 'month', 'jigo_ce' ),
		604800 => __( 'week', 'jigo_ce' ),
		86400 => __( 'day', 'jigo_ce' ),
		3600 => __( 'hour', 'jigo_ce' ),
		60 => __( 'minute', 'jigo_ce' ),
		1 => __( 'second', 'jigo_ce' )
	);
	foreach( $tokens as $unit => $text ) {
		if( $time < $unit )
			continue;
		$numberOfUnits = floor( $time / $unit );
		$output = $numberOfUnits . ' ' . $text . ( ( $numberOfUnits > 1 ) ? 's' : '' );
	}
	return $output;

}

// Escape all cells in 'Excel' CSV escape formatting of a CSV file, also converts HTML entities to plain-text
function jigo_ce_escape_csv_value( $string = '', $delimiter = ',', $format = 'all' ) {

	$string = str_replace( '"', '""', $string );
	$string = wp_specialchars_decode( $string );
	$string = str_replace( PHP_EOL, "\r\n", $string );
	switch( $format ) {

		case 'all':
			$string = '"' . $string . '"';
			break;

		case 'excel':
			if( strpos( $string, '"' ) !== false or strpos( $string, ',' ) !== false or strpos( $string, "\r" ) !== false or strpos( $string, "\n" ) !== false )
				$string = '"' . $string . '"';
			break;

	}
	return $string;

}

function jigo_ce_sanitize_key( $key ) {

	// Limit length of key to 24 characters
	$key = substr( $key, 0, 24 );
	return $key;

}

// Return the element count of an object
function jigo_ce_count_object( $object = 0, $exclude_post_types = array() ) {

	$count = 0;
	if( is_object( $object ) ) {
		if( $exclude_post_types ) {
			$size = count( $exclude_post_types );
			for( $i = 0; $i < $size; $i++ ) {
				if( isset( $object->$exclude_post_types[$i] ) )
					unset( $object->$exclude_post_types[$i] );
			}
		}
		if( !empty( $object ) ) {
			foreach( $object as $key => $item )
				$count = $item + $count;
		}
	} else {
		$count = $object;
	}
	return $count;

}

// Takes an array or comma separated string and returns an export formatted string 
function jigo_ce_convert_product_ids( $product_ids = null ) {

	global $export;

	$output = '';
	if( $product_ids !== null ) {
		if( is_array( $product_ids ) ) {
			$size = count( $product_ids );
			for( $i = 0; $i < $size; $i++ )
				$output .= $product_ids[$i] . $export->category_separator;
			$output = substr( $output, 0, -1 );
		} else if( strstr( $product_ids, ',' ) ) {
			$output = str_replace( ',', $export->category_separator, $product_ids );
		}
	}
	return $output;

}

function jigo_ce_format_product_status( $product_status = '' ) {

	$output = $product_status;
	switch( $product_status ) {

		case 'publish':
			$output = __( 'Publish', 'jigo_ce' );
			break;

		case 'draft':
			$output = __( 'Draft', 'jigo_ce' );
			break;

		case 'trash':
			$output = __( 'Trash', 'jigo_ce' );
			break;

	}
	return $output;

}

function jigo_ce_format_comment_status( $comment_status ) {

	$output = $comment_status;
	switch( $comment_status ) {

		case 'open':
			$output = __( 'Open', 'jigo_ce' );
			break;

		case 'closed':
			$output = __( 'Closed', 'jigo_ce' );
			break;

	}
	return $output;

}

function jigo_ce_format_switch( $input = '', $output_format = 'answer' ) {

	$input = strtolower( $input );
	switch( $input ) {

		case '1':
		case 'yes':
		case 'on':
		case 'open':
		case 'active':
			$input = '1';
			break;

		case '0':
		case 'no':
		case 'off':
		case 'closed':
		case 'inactive':
		default:
			$input = '0';
			break;

	}
	$output = '';
	switch( $output_format ) {

		case 'int':
			$output = $input;
			break;

		case 'answer':
			switch( $input ) {

				case '1':
					$output = __( 'Yes', 'jigo_ce' );
					break;

				case '0':
					$output = __( 'No', 'jigo_ce' );
					break;

			}
			break;

		case 'boolean':
			switch( $input ) {

				case '1':
					$output = 'on';
					break;

				case '0':
					$output = 'off';
					break;

			}
			break;

	}
	return $output;

}

function jigo_ce_format_customizable( $customizable = null ) {

	$output = '';
	if( $customizable ) {
		switch( $customizable ) {

			case 'yes':
				$output = __( 'Yes', 'jigo_ce' );
				break;

			case 'no':
				$output = __( 'No', 'jigo_ce' );
				break;

		}
	}
	return $output;

}

function jigo_ce_format_manage_stock( $manage_stock = null ) {

	$output = '';
	switch( $manage_stock ) {

		case '1':
		case 'yes':
			$output = __( 'Yes', 'jigo_ce' );
			break;

		case '-1':
		case '0':
		case 'no':
		default:
			$output = __( 'No', 'jigo_ce' );
			break;

	}
	return $output;

}

function jigo_ce_format_stock_status( $stock_status = '' ) {

	$output = '';
	if( $stock_status ) {
		switch( $stock_status ) {

			case 'instock':
				$output = __( 'In Stock', 'jigo_ce' );
				break;

			case 'outofstock':
				$output = __( 'Out of Stock', 'jigo_ce' );
				break;

		}
	}
	return $output;

}

function jigo_ce_format_allow_backorders( $allow_backorders = '' ) {

	$output = '';
	if( $allow_backorders ) {
		switch( $allow_backorders ) {

			case 'yes':
				$output = __( 'Allow', 'jigo_ce' );
				break;

			case 'no':
				$output = __( 'Do not allow', 'jigo_ce' );
				break;

			case 'notify':
				$output = __( 'Allow, but notify customer', 'jigo_ce' );
				break;

		}
	}
	return $output;

}

function jigo_ce_format_tax_status( $tax_status = null ) {

	$output = '';
	if( $tax_status ) {
		switch( $tax_status ) {
	
			case 'taxable':
				$output = __( 'Taxable', 'jigo_ce' );
				break;
	
			case 'shipping':
				$output = __( 'Shipping Only', 'jigo_ce' );
				break;

			case 'none':
				$output = __( 'None', 'jigo_ce' );
				break;

		}
	}
	return $output;

}

function jigo_ce_format_tax_classes( $tax_classes = array() ) {

	global $export;

	$output = '';
	if( $tax_classes ) {
		$size = count( $tax_classes );
		for( $i = 0; $i < $size; $i++ ) {
			switch( $tax_classes[$i] ) {

				case '*':
					$tax_classes[$i] = __( 'Standard', 'jigo_ce' );
					break;

				case 'reduced-rate':
					$tax_classes[$i] = __( 'Reduced Rate', 'jigo_ce' );
					break;

				case 'zero-rate':
					$tax_classes[$i] = __( 'Zero Rate', 'jigo_ce' );
					break;

			}
			if( $i == ( $size - 1 ) )
				$output .= $tax_classes[$i];
			else
				$output .= $tax_classes[$i] . $export->category_separator;
		}
	}
	return $output;

}

function jigo_ce_format_product_filters( $product_filters = array() ) {

	$output = array();
	if( !empty( $product_filters ) ) {
		foreach( $product_filters as $product_filter )
			$output[] = $product_filter;
	}
	return $output;

}

function jigo_ce_format_user_role_filters( $user_role_filters = array() ) {

	$output = array();
	if( !empty( $user_role_filters ) ) {
		foreach( $user_role_filters as $user_role_filter )
			$output[] = $user_role_filter;
	}
	return $output;

}

function jigo_ce_format_user_role_label( $user_role = '' ) {

	global $wp_roles;

	$output = $user_role;
	if( $user_role ) {
		$user_roles = jigo_ce_get_user_roles();
		if( isset( $user_roles[$user_role] ) )
			$output = ucfirst( $user_roles[$user_role]['name'] );
		unset( $user_roles );
	}
	return $output;

}

function jigo_ce_format_sale_price_dates( $sale_date = '' ) {

	$output = $sale_date;
	if( $sale_date )
		$output = jigo_ce_format_date( date( 'Y-m-d H:i:s', $sale_date ) );
	return $output;

}

function jigo_ce_format_date( $date = '' ) {

	$output = '';
	if( $date )
		$output = mysql2date( jigo_ce_get_option( 'date_format', 'd/m/Y' ), $date );
	return $output;

}

function jigo_ce_format_product_category_label( $product_category = '', $parent_category = '' ) {

	$output = $product_category;
	if( !empty( $parent_category ) )
		$output .= ' &raquo; ' . $parent_category;
	return $output;

}

function jigo_ce_currency_price( $price = 0 ) {

	$num_decimals = get_option( 'jigoshop_price_num_decimals', 2 );
	$output = number_format(
		(double)$price,
		(int)$num_decimals,
		get_option( 'jigoshop_price_decimal_sep', '.' ),
		get_option( 'jigoshop_price_thousand_sep', ',' )
	);
	return $output;

}

if( !function_exists( 'jigo_ce_expand_state_name' ) ) {
	function jigo_ce_expand_state_name( $country_name = '', $state_prefix = '' ) {

		$output = $state_prefix;
		if( $output ) {
			$country_code = jigo_ce_get_country_code( $country_name );
			if( $country_code && class_exists( 'jigoshop_countries' ) ) {
				$countries = new jigoshop_countries();
				$states = ( method_exists( $countries, 'get_states' ) ? $countries->get_states( $country_code ) : false );
				unset( $countries );
				if( $states ) {
					if( isset( $states[$state_prefix] ) )
						$output = $states[$state_prefix];
				}
				unset( $states );
			}
		}
		return $output;

	}
}

if( !function_exists( 'jigo_ce_get_country_code' ) ) {
	function jigo_ce_get_country_code( $country_name = '' ) {

		$output = $country_name;
		if( $output && class_exists( 'jigoshop_countries' ) ) {
			$countries = new jigoshop_countries();
			if( method_exists( $countries, 'get_allowed_countries' ) ) {
				$allowed_countries = $countries->get_allowed_countries();
				$country_code = array_search( $country_name, $allowed_countries );
				unset( $allowed_countries );
				if( $country_code )
					$output = $country_code;
				unset( $country_code );
			}
			unset( $countries );
		}
		return $output;

	}
}
?>
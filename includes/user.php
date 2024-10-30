<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	// HTML template for User Sorting widget on Store Exporter screen
	function jigo_ce_user_sorting() {

		$orderby = jigo_ce_get_option( 'user_orderby', 'ID' );
		$order = jigo_ce_get_option( 'user_order', 'ASC' );

		ob_start(); ?>
<p><label><?php _e( 'User Sorting', 'jigo_ce' ); ?></label></p>
<div>
	<select name="user_orderby">
		<option value="ID"<?php selected( 'ID', $orderby ); ?>><?php _e( 'User ID', 'jigo_ce' ); ?></option>
		<option value="display_name"<?php selected( 'display_name', $orderby ); ?>><?php _e( 'Display Name', 'jigo_ce' ); ?></option>
		<option value="user_name"<?php selected( 'user_name', $orderby ); ?>><?php _e( 'Name', 'jigo_ce' ); ?></option>
		<option value="user_login"<?php selected( 'user_login', $orderby ); ?>><?php _e( 'Username', 'jigo_ce' ); ?></option>
		<option value="nicename"<?php selected( 'nicename', $orderby ); ?>><?php _e( 'Nickname', 'jigo_ce' ); ?></option>
		<option value="email"<?php selected( 'email', $orderby ); ?>><?php _e( 'E-mail', 'jigo_ce' ); ?></option>
		<option value="url"<?php selected( 'url', $orderby ); ?>><?php _e( 'Website', 'jigo_ce' ); ?></option>
		<option value="registered"<?php selected( 'registered', $orderby ); ?>><?php _e( 'Date Registered', 'jigo_ce' ); ?></option>
		<option value="rand"<?php selected( 'rand', $orderby ); ?>><?php _e( 'Random', 'jigo_ce' ); ?></option>
	</select>
	<select name="user_order">
		<option value="ASC"<?php selected( 'ASC', $order ); ?>><?php _e( 'Ascending', 'jigo_ce' ); ?></option>
		<option value="DESC"<?php selected( 'DESC', $order ); ?>><?php _e( 'Descending', 'jigo_ce' ); ?></option>
	</select>
	<p class="description"><?php _e( 'Select the sorting of Users within the exported file. By default this is set to export User by User ID in Desending order.', 'jigo_ce' ); ?></p>
</div>
<?php
		ob_end_flush();

	}

	/* End of: WordPress Administration */

}

// Returns a list of User export columns
function jigo_ce_get_user_fields( $format = 'full' ) {

	$export_type = 'user';

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
		'name' => 'first_name',
		'label' => __( 'First Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'last_name',
		'label' => __( 'Last Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'full_name',
		'label' => __( 'Full Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'nick_name',
		'label' => __( 'Nickname', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'email',
		'label' => __( 'E-mail', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'url',
		'label' => __( 'Website', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'date_registered',
		'label' => __( 'Date Registered', 'jigo_ce' )
	);

/*
	$fields[] = array(
		'name' => '',
		'label' => __( '', 'jigo_ce' )
	);
*/

	// Allow Plugin/Theme authors to add support for additional columns
	$fields = apply_filters( 'jigo_ce_' . $export_type . '_fields', $fields, $export_type );

	if( $remember = jigo_ce_get_option( 'user_fields', array() ) ) {
		$remember = maybe_unserialize( $remember );
		$size = count( $fields );
		for( $i = 0; $i < $size; $i++ ) {
			$fields[$i]['disabled'] = ( isset( $fields[$i]['disabled'] ) ? $fields[$i]['disabled'] : 0 );
			$fields[$i]['default'] = 1;
			if( !array_key_exists( $fields[$i]['name'], $remember ) )
				$fields[$i]['default'] = 0;
		}
	}

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

// Returns the export column header label based on an export column slug
function jigo_ce_get_user_field( $name = null, $format = 'name' ) {

	$output = '';
	if( $name ) {
		$fields = jigo_ce_get_user_fields();
		$size = count( $fields );
		for( $i = 0; $i < $size; $i++ ) {
			if( $fields[$i]['name'] == $name ) {
				switch( $format ) {

					case 'name':
						$output = $fields[$i]['label'];
						break;

					case 'full':
						$output = $fields[$i];
						break;

				}
				$i = $size;
			}
		}
	}
	return $output;

}

// Returns a list of User IDs
function jigo_ce_get_users( $args = array() ) {

	global $export;

	$limit_volume = 0;
	$offset = 0;
	$orderby = 'login';
	$order = 'ASC';

	if( $args ) {
		$limit_volume = ( isset( $args['limit_volume'] ) ? $args['limit_volume'] : 0 );
		if( $limit_volume == -1 )
			$limit_volume = 0;
		$offset = ( isset( $args['offset'] ) ? $args['offset'] : 0 );
		$orderby = ( isset( $args['user_orderby'] ) ? $args['user_orderby'] : 'login' );
		$order = ( isset( $args['user_order'] ) ? $args['user_order'] : 'ASC' );
	}
	$args = array(
		'offset' => $offset,
		'number' => $limit_volume,
		'order' => $order,
		'offset' => $offset,
		'fields' => 'ids'
	);
	if( $user_ids = new WP_User_Query( $args ) ) {
		$users = array();
		$export->total_rows = $user_ids->total_users;
		foreach( $user_ids->results as $user_id )
			$users[] = $user_id;
		return $users;
	}

}

function jigo_ce_get_user_data( $user_id = 0, $args = array() ) {

	global $export;

	$defaults = array();
	$args = wp_parse_args( $args, $defaults );

	// Get User details
	$user_data = get_userdata( $user_id );

	$user = new stdClass;
	if( $user_data !== false ) {
		$user->ID = $user_data->ID;
		$user->user_id = $user_data->ID;
		$user->user_name = $user_data->user_login;
		$user->user_role = $user_data->roles[0];
		$user->first_name = $user_data->first_name;
		$user->last_name = $user_data->last_name;
		$user->full_name = sprintf( '%s %s', $user->first_name, $user->last_name );
		$user->nick_name = $user_data->user_nicename;
		$user->email = $user_data->user_email;
		$user->url = $user_data->user_url;
		$user->date_registered = $user_data->user_registered;
	}
	return apply_filters( 'jigo_ce_user', $user );
	
}
?>
<?php
include_once( JIGO_CE_PATH . 'includes/product.php' );
include_once( JIGO_CE_PATH . 'includes/category.php' );
include_once( JIGO_CE_PATH . 'includes/tag.php' );
include_once( JIGO_CE_PATH . 'includes/order.php' );
include_once( JIGO_CE_PATH . 'includes/customer.php' );
include_once( JIGO_CE_PATH . 'includes/user.php' );
include_once( JIGO_CE_PATH . 'includes/coupon.php' );

// Check if we are using PHP 5.3 and above
if( version_compare( phpversion(), '5.3' ) >= 0 )
	include_once( JIGO_CE_PATH . 'includes/legacy.php' );
include_once( JIGO_CE_PATH . 'includes/formatting.php' );

include_once( JIGO_CE_PATH . 'includes/export-csv.php' );

if( is_admin() ) {

	/* Start of: WordPress Administration */

	include_once( JIGO_CE_PATH . 'includes/admin.php' );
	include_once( JIGO_CE_PATH . 'includes/settings.php' );

	function jigo_ce_detect_non_jigo_install() {

		$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';
		if( !jigo_is_woo_activated() && ( jigo_is_woo_activated() || jigo_is_wpsc_activated() ) ) {
			$message = sprintf( __( 'We have detected another e-Commerce Plugin than Jigoshop activated, please check that you are using Store Exporter Deluxe for the correct platform. <a href="%s" target="_blank">Need help?</a>', 'jigo_ce' ), $troubleshooting_url );
			jigo_ce_admin_notice( $message, 'error', 'plugins.php' );
		} else if( !jigo_is_jigo_activated() ) {
			$message = sprintf( __( 'We have been unable to detect the Jigoshop Plugin activated on this WordPress site, please check that you are using Store Exporter Deluxe for the correct platform. <a href="%s" target="_blank">Need help?</a>', 'jigo_ce' ), $troubleshooting_url );
			jigo_ce_admin_notice( $message, 'error', 'plugins.php' );
		}
		jigo_ce_plugin_page_notices();

	}

	// Displays a HTML notice when a WordPress or Store Exporter error is encountered
	function jigo_ce_admin_fail_notices() {

		$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

		// If the failed flag is set then prepare for an error notice
		if( isset( $_GET['failed'] ) ) {
			$message = '';
			if( isset( $_GET['message'] ) )
				$message = urldecode( $_GET['message'] );
			if( $message )
				$message = sprintf( __( 'A WordPress or server error caused the exporter to fail, the exporter was provided with a reason: <em>%s</em>', 'jigo_ce' ), $message ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigo_ce' ) . '</a>)';
			else
				$message = __( 'A WordPress or server error caused the exporter to fail, no reason was provided, please get in touch so we can reproduce and resolve this.', 'jigo_ce' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigo_ce' ) . '</a>)';
			jigo_ce_admin_notice_html( $message, 'error' );
		}

		// Displays a HTML notice where the maximum execution time cannot be set
		if( !jigo_ce_get_option( 'dismiss_execution_time_prompt', 0 ) ) {
			$max_execution_time = absint( ini_get( 'max_execution_time' ) );
			$response = ini_set( 'max_execution_time', 120 );
			if( $response == false || ( $response != $max_execution_time ) ) {
				$dismiss_url = esc_url( add_query_arg( array( 'action' => 'dismiss_execution_time_prompt', '_wpnonce' => wp_create_nonce( 'jigo_ce_dismiss_execution_time_prompt' ) ) ) );
				$message = '<span style="float:right;"><a href="' . $dismiss_url . '">' . __( 'Dismiss', 'jigoshop-exporter' ) . '</a></span>' . sprintf( __( 'We could not override the PHP configuration option <code>max_execution_time</code>, this will limit the size of possible exports. See: <a href="%s" target="_blank">Increasing PHP max_execution_time configuration option</a>', 'jigoshop-exporter' ), $troubleshooting_url );
				jigo_ce_admin_notice_html( $message );
			}
		}

		// Displays a HTML notice where the memory allocated to WordPress falls below 64MB
		if( !jigo_ce_get_option( 'dismiss_memory_prompt', 0 ) ) {
			$memory_limit = absint( ini_get( 'memory_limit' ) );
			$minimum_memory_limit = 64;
			if( $memory_limit < $minimum_memory_limit ) {
				$dismiss_url = esc_url( add_query_arg( array( 'action' => 'dismiss_memory_prompt', '_wpnonce' => wp_create_nonce( 'jigo_ce_dismiss_memory_prompt' ) ) ) );
				$message = '<span style="float:right;"><a href="' . $dismiss_url . '">' . __( 'Dismiss', 'jigoshop-exporter' ) . '</a></span>' . sprintf( __( 'We recommend setting memory to at least %dMB, your site has only %dMB allocated to it. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', 'jigoshop-exporter' ), $minimum_memory_limit, $memory_limit, $troubleshooting_url );
				jigo_ce_admin_notice_html( $message, 'error' );
			}
		}

		// Displays a HTML notice if PHP 5.2 or lower is installed
		if( version_compare( phpversion(), '5.3', '<' ) && !jigo_ce_get_option( 'dismiss_php_legacy', 0 ) ) {
			$dismiss_url = esc_url( add_query_arg( array( 'action' => 'dismiss_php_legacy', '_wpnonce' => wp_create_nonce( 'jigo_ce_dismiss_php_legacy' ) ) ) );
			$message = '<span style="float:right;"><a href="' . $dismiss_url . '">' . __( 'Dismiss', 'jigoshop-exporter' ) . '</a></span>' . sprintf( __( 'Your PHP version (%s) is not supported and is very much out of date, since 2010 all users are strongly encouraged to upgrade to PHP 5.3+ and above. Contact your hosting provider to make this happen. See: <a href="%s" target="_blank">Migrating from PHP 5.2 to 5.3</a>', 'jigoshop-exporter' ), phpversion(), $troubleshooting_url );
			jigo_ce_admin_notice_html( $message, 'error' );
		}

		// If the export failed the WordPress Transient will still exist
		if( get_transient( JIGO_CE_PREFIX . '_running' ) ) {
			$message = __( 'A WordPress or server error caused the exporter to fail with a blank screen, this is either a memory or timeout issue, please get in touch so we can reproduce and resolve this.', 'jigo_ce' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigo_ce' ) . '</a>)';
			jigo_ce_admin_notice_html( $message, 'error' );
			delete_transient( JIGO_CE_PREFIX . '_running' );
		}

	}

	function jigo_ce_plugin_page_notices() {

		global $pagenow;

		if( $pagenow == 'plugins.php' ) {
			if( jigo_is_woo_activated() || jigo_is_wpsc_activated() ) {
				$r_plugins = array(
					'jigoshop-exporter/exporter.php',
					'jigoshop-store-exporter/exporter.php'
				);
				$i_plugins = get_plugins();
				foreach( $r_plugins as $path ) {
					if( isset( $i_plugins[$path] ) ) {
						add_action( 'after_plugin_row_' . $path, 'jigo_ce_plugin_page_notice', 10, 3 );
						break;
					}
				}
			}
		}
	}

	function jigo_ce_plugin_page_notice( $file, $data, $context ) {

		if( is_plugin_active( $file ) ) { ?>
<tr class='plugin-update-tr su-plugin-notice'>
	<td colspan='3' class='plugin-update colspanchange'>
		<div class='update-message'>
			<?php printf( __( '%1$s is intended to be used with a Jigoshop store, please check that you are using Store Exporter with the correct e-Commerce platform.', 'jigo_ce' ), $data['Name'] ); ?>
		</div>
	</td>
</tr>
<?php
		}

	}

	// Saves the state of Export fields for next export
	function jigo_ce_save_fields( $export_type = '', $fields = array(), $sorting = array() ) {

		// Default fields
		if( $fields == false && !is_array( $fields ) )
			$fields = array();
		$export_types = array_keys( jigo_ce_get_export_types() );
		if( in_array( $export_type, $export_types ) && !empty( $fields ) ) {
			jigo_ce_update_option( $export_type . '_fields', array_map( 'sanitize_text_field', $fields ) );
			jigo_ce_update_option( $export_type . '_sorting', array_map( 'absint', $sorting ) );
		}

	}

	// Returns number of an Export type prior to export, used on Store Exporter screen
	function jigo_ce_return_count( $export_type = '', $args = array() ) {

		global $wpdb;

		$count_sql = null;
		switch( $export_type ) {

			case 'product':
				$post_type = array( 'product' );
				$args = array(
					'post_type' => $post_type,
					'posts_per_page' => 1,
					'fields' => 'ids'
				);
				$count_query = new WP_Query( $args );
				$count = $count_query->found_posts;
				break;

			case 'category':
				$term_taxonomy = 'product_cat';
				if( taxonomy_exists( $term_taxonomy ) )
					$count = wp_count_terms( $term_taxonomy );
				break;

			case 'tag':
				$term_taxonomy = 'product_tag';
				if( taxonomy_exists( $term_taxonomy ) )
					$count = wp_count_terms( $term_taxonomy );
				break;

			case 'order':
				$post_type = 'shop_order';
				$args = array(
					'post_type' => $post_type,
					'posts_per_page' => 1,
					'fields' => 'ids'
				);
				$count_query = new WP_Query( $args );
				$count = $count_query->found_posts;
				break;

			case 'customer':
				$post_type = 'shop_order';
				$count = wp_count_posts( $post_type );
				$exclude_post_types = array( 'auto-draft' );
				if( jigo_ce_count_object( $count, $exclude_post_types ) > 100 ) {
					$count = sprintf( '~%s *', jigo_ce_count_object( $count, $exclude_post_types ) );
				} else {
					$count = 0;
					$args = array(
						'post_type' => $post_type,
						'numberposts' => -1,
						'post_status' => jigo_ce_post_statuses(),
						'tax_query' => array(
							array(
								'taxonomy' => 'shop_order_status',
								'field' => 'slug',
								'terms' => array( 'pending', 'on-hold', 'processing', 'completed' )
							)
						)
					);
					$orders = get_posts( $args );
					if( $orders ) {
						$customers = array();
						foreach( $orders as $order ) {
							$order_data = get_post_meta( $order->ID, 'order_data', true );
							$order->email = $order_data['billing_email'];
							if( empty( $order->email ) ) {
								if( $order->user_id = get_post_meta( $order->ID, 'customer_user', true ) ) {
									$user = get_userdata( $order->user_id );
									if( $user )
										$order->email = $user->user_email;
									unset( $user );
								} else {
									$order->email = '-';
								}
							}
							if( !in_array( $order->email, $customers ) ) {
								$customers[$order->ID] = $order->email;
								$count++;
							}
							unset( $order_data );
						}
						unset( $orders, $order );
					}
				}
				break;

			case 'user':
				if( $users = count_users() )
					$count = $users['total_users'];
				break;

			case 'coupon':
				$coupons = get_option( 'jigoshop_coupons' );
				$count = count( $coupons );
				break;

		}
		if( isset( $count ) || $count_sql ) {
			if( isset( $count ) ) {
				if( is_object( $count ) ) {
					$count = (array)$count;
					$count = absint( array_sum( $count ) );
				}
				return $count;
			} else {
				if( $count_sql )
					$count = $wpdb->get_var( $count_sql );
				else
					$count = 0;
			}
			return $count;
		} else {
			return 0;
		}

	}

	// In-line display of export file and export details when viewed via WordPress Media screen
	function jigo_ce_read_export_file( $post = false ) {

		if( empty( $post ) ) {
			if( isset( $_GET['post'] ) )
				$post = get_post( $_GET['post'] );
		}

		if( $post->post_type != 'attachment' )
			return;

		// Check if the Post matches one of our Post Mime Types
		if( !in_array( $post->post_mime_type, array( 'text/csv', 'application/xml', 'application/vnd.ms-excel' ) ) )
			return;

		$filename = $post->post_name;
		$filepath = get_attached_file( $post->ID );

		$contents = __( 'No export entries were found, please try again with different export filters.', 'jigo_ce' );
		if( file_exists( $filepath ) ) {
			$handle = fopen( $filepath, "r" );
			$contents = stream_get_contents( $handle );
			fclose( $handle );
		} else {
			// This resets the _wp_attached_file Post meta key to the correct value
			update_attached_file( $post->ID, $post->guid );
			// Try grabbing the file contents again
			$filepath = get_attached_file( $post->ID );
			if( file_exists( $filepath ) ) {
				$handle = fopen( $filepath, "r" );
				$contents = stream_get_contents( $handle );
				fclose( $handle );
			}
		}
		if( !empty( $contents ) )
			include_once( JIGO_CE_PATH . 'templates/admin/media-csv_file.php' );


		// We can still show the Export Details for any supported Post Mime Type
		$export_type = get_post_meta( $post->ID, '_jigo_export_type', true );
		$columns = get_post_meta( $post->ID, '_jigo_columns', true );
		$rows = get_post_meta( $post->ID, '_jigo_rows', true );
		$start_time = get_post_meta( $post->ID, '_jigo_start_time', true );
		$end_time = get_post_meta( $post->ID, '_jigo_end_time', true );
		$idle_memory_start = get_post_meta( $post->ID, '_jigo_idle_memory_start', true );
		$data_memory_start = get_post_meta( $post->ID, '_jigo_data_memory_start', true );
		$data_memory_end = get_post_meta( $post->ID, '_jigo_data_memory_end', true );
		$idle_memory_end = get_post_meta( $post->ID, '_jigo_idle_memory_end', true );

		include_once( JIGO_CE_PATH . 'templates/admin/media-export_details.php' );

	}
	add_action( 'edit_form_after_editor', 'jigo_ce_read_export_file' );

	// Returns label of Export type slug used on Store Exporter screen
	function jigo_ce_export_type_label( $export_type = '', $echo = false ) {

		$output = '';
		if( !empty( $export_type ) ) {
			$export_types = jigo_ce_get_export_types();
			if( array_key_exists( $export_type, $export_types ) )
				$output = $export_types[$export_type];
		}
		if( $echo )
			echo $output;
		else
			return $output;

	}

	function jigo_ce_export_options_export_format() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		ob_start(); ?>
<tr>
	<th>
		<label><?php _e( 'Export format', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<label><input type="radio" name="export_format" value="csv"<?php checked( 'csv', 'csv' ); ?> /> <?php _e( 'CSV', 'jigo_ce' ); ?> <span class="description"><?php _e( '(Comma separated values)', 'jigo_ce' ); ?></span></label><br />
		<label><input type="radio" name="export_format" value="xml" disabled="disabled" /> <?php _e( 'XML', 'jigo_ce' ); ?> <span class="description"><?php _e( '(EXtensible Markup Language)', 'jigo_ce' ); ?> <span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label><br />
		<label><input type="radio" name="export_format" value="xls" disabled="disabled" /> <?php _e( 'Excel (XLS)', 'jigo_ce' ); ?> <span class="description"><?php _e( '(Microsoft Excel 2007)', 'jigo_ce' ); ?> <span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label>
		<p class="description"><?php _e( 'Adjust the export format to generate different export file formats.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<?php
		ob_end_flush();

	}

	// Returns a list of archived exports
	function jigo_ce_get_archive_files() {

		$post_type = 'attachment';
		$meta_key = '_jigo_export_type';
		$args = array(
			'post_type' => $post_type,
			'post_mime_type' => array( 'text/csv', 'application/xml', 'application/vnd.ms-excel' ),
			'meta_key' => $meta_key,
			'meta_value' => null,
			'post_status' => 'any',
			'posts_per_page' => -1
		);
		if( isset( $_GET['filter'] ) ) {
			$filter = $_GET['filter'];
			if( !empty( $filter ) )
				$args['meta_value'] = $filter;
		}
		$files = get_posts( $args );
		return $files;

	}

	// Returns an archived export with additional details
	function jigo_ce_get_archive_file( $file = '' ) {

		$wp_upload_dir = wp_upload_dir();
		$file->export_type = get_post_meta( $file->ID, '_jigo_export_type', true );
		$file->export_type_label = jigo_ce_export_type_label( $file->export_type );
		if( empty( $file->export_type ) )
			$file->export_type = __( 'Unassigned', 'jigo_ce' );
		if( empty( $file->guid ) )
			$file->guid = $wp_upload_dir['url'] . '/' . basename( $file->post_title );
		$file->post_mime_type = get_post_mime_type( $file->ID );
		if( !$file->post_mime_type )
			$file->post_mime_type = __( 'N/A', 'jigo_ce' );
		$file->media_icon = wp_get_attachment_image( $file->ID, array( 80, 60 ), true );
		if( $author_name = get_user_by( 'id', $file->post_author ) )
			$file->post_author_name = $author_name->display_name;
		$t_time = strtotime( $file->post_date, current_time( 'timestamp' ) );
		$time = get_post_time( 'G', true, $file->ID, false );
		if( ( abs( $t_diff = time() - $time ) ) < 86400 )
			$file->post_date = sprintf( __( '%s ago' ), human_time_diff( $time ) );
		else
			$file->post_date = mysql2date( __( 'Y/m/d' ), $file->post_date );
		unset( $author_name, $t_time, $time );
		return $file;

	}

	// HTML template for displaying the current export type filter on the Archives screen
	function jigo_ce_archives_quicklink_current( $current = '' ) {

		$output = '';
		if( isset( $_GET['filter'] ) ) {
			$filter = $_GET['filter'];
			if( $filter == $current )
				$output = ' class="current"';
		} else if( $current == 'all' ) {
			$output = ' class="current"';
		}
		echo $output;

	}

	// HTML template for displaying the number of each export type filter on the Archives screen
	function jigo_ce_archives_quicklink_count( $type = '' ) {

		$post_type = 'attachment';
		$meta_key = '_jigo_export_type';
		$args = array(
			'post_type' => $post_type,
			'meta_key' => $meta_key,
			'meta_value' => null,
			'numberposts' => -1,
			'post_status' => 'any',
			'fields' => 'ids'
		);
		if( !empty( $type ) )
			$args['meta_value'] = $type;
		$post_query = new WP_Query( $args );
		return absint( $post_query->found_posts );

	}

	/* End of: WordPress Administration */

}

// Export process for CSV file
function jigo_ce_export_dataset( $export_type = null, &$output = null ) {

	global $export;

	$separator = $export->delimiter;
	$export->columns = array();
	$export->total_rows = 0;
	$export->total_columns = 0;

	$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

	set_transient( JIGO_CE_PREFIX . '_running', time(), jigo_ce_get_option( 'timeout', MINUTE_IN_SECONDS ) );

	// Load up the fatal error notice if we 500 Internal Server Error (memory), hit a server timeout or encounter a fatal PHP error
	add_action( 'shutdown', 'jigo_ce_fatal_error' );

	// Drop in our content filters here
	add_filter( 'sanitize_key', 'jigo_ce_sanitize_key' );

	switch( $export_type ) {

		// Products
		case 'product':
			$fields = jigo_ce_get_product_fields( 'summary' );
			if( $export->fields = array_intersect_assoc( (array)$export->fields, $fields ) ) {
				foreach( $export->fields as $key => $field )
					$export->columns[] = jigo_ce_get_product_field( $key );
			}
			$export->data_memory_start = jigo_ce_current_memory_usage();
/*
			$attributes = jigo_ce_return_product_attributes();
			if( $attributes ) {
				foreach( $attributes as $attribute )
					$export->columns[] = sprintf( __( 'Attribute - %s', 'jigo_ce' ), $attribute['label'] );
				unset( $attributes, $attribute );
			}
*/
			if( $products = jigo_ce_get_products( $export->args ) ) {
				$export->total_rows = count( $products );
				$export->total_columns = $size = count( $export->columns );
				// Generate the export headers
				if( in_array( $export->export_format, array( 'csv', 'xls' ) ) ) {
					for( $i = 0; $i < $size; $i++ ) {
						if( $i == ( $size - 1 ) )
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . "\n";
						else
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . $separator;
					}
				}
				$weight_unit = get_option( 'jigoshop_weight_unit' );
				$dimension_unit = get_option( 'jigoshop_dimension_unit' );
				$height_unit = $dimension_unit;
				$width_unit = $dimension_unit;
				$length_unit = $dimension_unit;
				if( !empty( $export->fields ) ) {
					foreach( $products as $product ) {

						$product = jigo_ce_get_product_data( $product, $export->args );
						foreach( $export->fields as $key => $field ) {
							if( isset( $product->$key ) ) {
								if( is_array( $field ) ) {
									foreach( $field as $array_key => $array_value ) {
										if( !is_array( $array_value ) ) {
											if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
												$output .= jigo_ce_escape_csv_value( $array_value, $export->delimiter, $export->escape_formatting );
											else if( $export->export_format == 'xml' )
												$child->addChild( $array_key, htmlspecialchars( $array_value ) );
										}
									}
								} else {
									if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
										$output .= jigo_ce_escape_csv_value( $product->$key, $export->delimiter, $export->escape_formatting );
									else if( $export->export_format == 'xml' )
										$child->addChild( $key, htmlspecialchars( $product->$key ) );
								}
							}
							if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
								$output .= $separator;
						}

						if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
							$output = substr( $output, 0, -1 ) . "\n";
					}
				}
				unset( $products, $product );
			}
			$export->data_memory_end = jigo_ce_current_memory_usage();
			break;

		// Categories
		case 'category':
			$fields = jigo_ce_get_category_fields( 'summary' );
			if( $export->fields = array_intersect_assoc( $fields, (array)$export->fields ) ) {
				foreach( $export->fields as $key => $field )
					$export->columns[] = jigo_ce_get_category_field( $key );
			}
			$export->data_memory_start = jigo_ce_current_memory_usage();
			$category_args = array(
				'orderby' => ( isset( $export->args['category_orderby'] ) ? $export->args['category_orderby'] : 'ID' ),
				'order' => ( isset( $export->args['category_order'] ) ? $export->args['category_order'] : 'ASC' ),
			);
			if( $categories = jigo_ce_get_product_categories( $category_args ) ) {
				$export->total_rows = count( $categories );
				$export->total_columns = $size = count( $export->columns );
				// Generate the export headers
				if( in_array( $export->export_format, array( 'csv', 'xls' ) ) ) {
					for( $i = 0; $i < $size; $i++ ) {
						if( $i == ( $size - 1 ) )
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . "\n";
						else
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . $separator;
					}
				}
				if( !empty( $export->fields ) ) {
					foreach( $categories as $category ) {

						foreach( $export->fields as $key => $field ) {
							if( isset( $category->$key ) ) {
								if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
									$output .= jigo_ce_escape_csv_value( $category->$key, $export->delimiter, $export->escape_formatting );
								else if( $export->export_format == 'xml' )
									$child->addChild( $key, htmlspecialchars( $category->$key ) );
							}
							if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
								$output .= $separator;
						}
						if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
							$output = substr( $output, 0, -1 ) . "\n";
					}
				}
				unset( $categories, $category );
			}
			$export->data_memory_end = jigo_ce_current_memory_usage();
			break;

		// Tags
		case 'tag':
			$fields = jigo_ce_get_tag_fields( 'summary' );
			if( $export->fields = array_intersect_assoc( $fields, (array)$export->fields ) ) {
				foreach( $export->fields as $key => $field )
					$export->columns[] = jigo_ce_get_tag_field( $key );
			}
			$export->data_memory_start = jigo_ce_current_memory_usage();
			$tag_args = array(
				'orderby' => ( isset( $export->args['tag_orderby'] ) ? $export->args['tag_orderby'] : 'ID' ),
				'order' => ( isset( $export->args['tag_order'] ) ? $export->args['tag_order'] : 'ASC' ),
			);
			if( $tags = jigo_ce_get_product_tags( $tag_args ) ) {
				$export->total_rows = count( $tags );
				$export->total_columns = $size = count( $export->columns );
				// Generate the export headers
				if( in_array( $export->export_format, array( 'csv', 'xls' ) ) ) {
					for( $i = 0; $i < $size; $i++ ) {
						if( $i == ( $size - 1 ) )
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . "\n";
						else
							$output .= jigo_ce_escape_csv_value( $export->columns[$i], $export->delimiter, $export->escape_formatting ) . $separator;
					}
				}
				if( !empty( $export->fields ) ) {
					foreach( $tags as $tag ) {

						foreach( $export->fields as $key => $field ) {
							if( isset( $tag->$key ) ) {
								if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
									$output .= jigo_ce_escape_csv_value( $tag->$key, $export->delimiter, $export->escape_formatting );
								else if( $export->export_format == 'xml' )
									$child->addChild( $key, htmlspecialchars( $tag->$key ) );
							}
							if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
								$output .= $separator;
						}
						if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
							$output = substr( $output, 0, -1 ) . "\n";
					}
				}
				unset( $tags, $tag );
			}
			$export->data_memory_end = jigo_ce_current_memory_usage();
			break;

		// Users
		case 'user':
			$fields = jigo_ce_get_user_fields( 'summary' );
			if( $export->fields = array_intersect_assoc( $fields, (array)$export->fields ) ) {
				foreach( $export->fields as $key => $field )
					$export->columns[] = jigo_ce_get_user_field( $key );
			}
			$export->data_memory_start = jigo_ce_current_memory_usage();
			if( $users = jigo_ce_get_users( $export->args ) ) {
				$export->total_columns = $size = count( $export->columns );
				if( in_array( $export->export_format, array( 'csv', 'xls' ) ) ) {
					$i = 0;
					foreach( $export->columns as $column ) {
						if( $i == ( $size - 1 ) )
							$output .= jigo_ce_escape_csv_value( $column, $export->delimiter, $export->escape_formatting ) . "\n";
						else
							$output .= jigo_ce_escape_csv_value( $column, $export->delimiter, $export->escape_formatting ) . $separator;
						$i++;
					}
				}
				if( !empty( $export->fields ) ) {
					foreach( $users as $user ) {

						$user = jigo_ce_get_user_data( $user, $export->args );

						foreach( $export->fields as $key => $field ) {
							if( isset( $user->$key ) ) {
								if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
									$output .= jigo_ce_escape_csv_value( $user->$key, $export->delimiter, $export->escape_formatting );
								else if( $export->export_format == 'xml' )
									$child->addChild( $key, htmlspecialchars( $user->$key ) );
							}
							if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
								$output .= $separator;
						}
						if( in_array( $export->export_format, array( 'csv', 'xls' ) ) )
							$output = substr( $output, 0, -1 ) . "\n";

					}
				}
				unset( $users, $user );
			}
			$export->data_memory_end = jigo_ce_current_memory_usage();
			break;

	}

	// Remove our content filters here to play nice with other Plugins
	remove_filter( 'sanitize_key', 'jigo_ce_sanitize_key' );

	// Remove our fatal error notice so not to conflict with the CRON or scheduled export engine	
	remove_action( 'shutdown', 'jigo_ce_fatal_error' );

	// Export completed successfully
	delete_transient( JIGO_CE_PREFIX . '_running' );

	// Check that the export file is populated, export columns have been assigned and rows counted
	if( $output && $export->total_rows && $export->total_columns ) {
		if( in_array( $export->export_format, array( 'csv', 'xls' ) ) ) {
			$output = jigo_ce_file_encoding( $output );
			if( $export->export_format == 'csv' && $export->bom && ( JIGO_CE_DEBUG == false ) )
				$output = "\xEF\xBB\xBF" . $output;
		}
		if( JIGO_CE_DEBUG && !$export->cron ) {
			$response = set_transient( JIGO_CE_PREFIX . '_debug_log', base64_encode( $output ), jigo_ce_get_option( 'timeout', MINUTE_IN_SECONDS ) );
			if( $response !== true ) {
				$message = __( 'The export contents were too large to store in a single WordPress transient, use the Volume offset / Limit volume options to reduce the size of your export and try again.', 'jigo_ce' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigo_ce' ) . '</a>)';
				if( function_exists( 'jigo_cd_admin_notice' ) )
					jigo_ce_admin_notice( $message, 'error' );
				else
					error_log( sprintf( '[store-exporter] jigo_ce_export_dataset() - %s', $message ) );
			}
		} else {
			return $output;
		}
	}

}

function jigo_ce_fatal_error() {

	global $export;

	$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter/usage/';

	$error = error_get_last();
	if( $error !== null ) {
		$message = '';
		$notice = sprintf( __( 'Refer to the following error and contact us on http://wordpress.org/plugins/jigoshop-exporter/ for further assistance. Error: <code>%s</code>', 'jigoshop-exporter' ), $error['message'] );
		if ( substr( $error['message'], 0, 22 ) === 'Maximum execution time' ) {
			$message = __( 'The server\'s maximum execution time is too low to complete this export. This is commonly due to a low timeout limit set by your hosting provider or PHP Safe Mode being enabled.', 'jigoshop-exporter' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigoshop-exporter' ) . '</a>)';
		} elseif ( substr( $error['message'], 0, 19 ) === 'Allowed memory size' ) {
			$message = __( 'The server\'s maximum memory size is too low to complete this export. Consider increasing available memory to WordPress or reducing the size of your export.', 'jigoshop-exporter' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigoshop-exporter' ) . '</a>)';
		} else if( $error['type'] === E_ERROR ) {
			$message = __( 'A fatal PHP error was encountered during the export process, we couldn\'t detect or diagnose it further.', 'jigoshop-exporter' ) . ' (<a href="' . $troubleshooting_url . '" target="_blank">' . __( 'Need help?', 'jigoshop-exporter' ) . '</a>)';
		}
		if( !empty( $message ) ) {

			// Save a record to the PHP error log
			error_log( sprintf( __( '[store-exporter] Fatal error: %s - PHP response: %s in %s on line %s', 'jigoshop-exporter' ), $message, $error['message'], $error['file'], $error['line'] ) );

			// Only display the message if this is a manual export
			if( ( !$export->cron && !$export->scheduled_export ) ) {
				$output = '<div id="message" class="error"><p>' . sprintf( __( '<strong>[store-exporter]</strong> An unexpected error occurred. %s', 'jigoshop-exporter' ), $message ) . '</p><p>' . $notice . '</p></div>';
				echo $output;
			}

		}
	}

}

// List of Export types used on Store Exporter screen
function jigo_ce_get_export_types() {

	$types = array(
		'product' => __( 'Products', 'jigo_ce' ),
		'category' => __( 'Categories', 'jigo_ce' ),
		'tag' => __( 'Tags', 'jigo_ce' ),
		'user' => __( 'Users', 'jigo_ce' )
	);
	$types = apply_filters( 'jigo_ce_export_types', $types );
	return $types;

}

function jigo_ce_check_export_arguments( $args ) {

	$args->export_format = ( $args->export_format != '' ? $args->export_format : 'csv' );
	$args->limit_volume = ( $args->limit_volume != '' ? $args->limit_volume : -1 );
	$args->offset = ( $args->offset != '' ? $args->offset : 0 );
	return $args;

}

// Returns the Post object of the export file saved as an attachment to the WordPress Media library
function jigo_ce_save_file_attachment( $filename = '', $post_mime_type = 'text/csv' ) {

	if( !empty( $filename ) ) {
		$post_type = 'jigo-export';
		$args = array(
			'post_title' => $filename,
			'post_type' => $post_type,
			'post_mime_type' => $post_mime_type
		);
		$post_ID = wp_insert_attachment( $args, $filename );
		if( is_wp_error( $post_ID ) )
			jigo_ce_error_log( sprintf( 'save_file_attachment() - $s: %s', $filename, $result->get_error_message() ) );
		else
			return $post_ID;
	}

}

// Updates the GUID of the export file attachment to match the correct file URL
function jigo_ce_save_file_guid( $post_ID, $export_type, $upload_url = '' ) {

	add_post_meta( $post_ID, '_jigo_export_type', $export_type );
	if( !empty( $upload_url ) ) {
		$args = array(
			'ID' => $post_ID,
			'guid' => $upload_url
		);
		wp_update_post( $args );
	}

}

// Save critical export details against the archived export
function jigo_ce_save_file_details( $post_ID ) {

	global $export;

	add_post_meta( $post_ID, '_jigo_start_time', $export->start_time );
	add_post_meta( $post_ID, '_jigo_idle_memory_start', $export->idle_memory_start );
	add_post_meta( $post_ID, '_jigo_columns', $export->total_columns );
	add_post_meta( $post_ID, '_jigo_rows', $export->total_rows );
	add_post_meta( $post_ID, '_jigo_data_memory_start', $export->data_memory_start );
	add_post_meta( $post_ID, '_jigo_data_memory_end', $export->data_memory_end );

}

// Update detail of existing archived export
function jigo_ce_update_file_detail( $post_ID, $detail, $value ) {

	if( strstr( $detail, '_jigo_' ) !== false )
		update_post_meta( $post_ID, $detail, $value );

}

// Returns a list of allowed Export type statuses, can be overridden on a per-Export type basis
function jigo_ce_post_statuses( $extra_status = array(), $override = false ) {

	$output = array(
		'publish',
		'pending',
		'draft',
		'future',
		'private',
		'trash'
	);
	if( $override ) {
		$output = $extra_status;
	} else {
		if( $extra_status )
			$output = array_merge( $output, $extra_status );
	}
	return $output;

}

// Returns a list of WordPress User Roles
function jigo_ce_get_user_roles() {

	global $wp_roles;

	$user_roles = $wp_roles->roles;
	return $user_roles;

}

function jigo_ce_add_missing_mime_type( $mime_types = array() ) {

	// Add CSV mime type if it has been removed
	if( !isset( $mime_types['csv'] ) )
		$mime_types['csv'] = 'text/csv';
	return $mime_types;

}
add_filter( 'upload_mimes', 'jigo_ce_add_missing_mime_type', 10, 1 );

if( !function_exists( 'jigo_ce_sort_fields' ) ) {
	function jigo_ce_sort_fields( $key ) {

		return $key;

	}
}

// Add Store Export to filter types on the WordPress Media screen
function jigo_ce_add_post_mime_type( $post_mime_types = array() ) {

	$post_mime_types['text/csv'] = array( __( 'Store Exports (CSV)', 'jigo_ce' ), __( 'Manage Store Exports (CSV)', 'jigo_ce' ), _n_noop( 'Store Export - CSV <span class="count">(%s)</span>', 'Store Exports - CSV <span class="count">(%s)</span>' ) );
	return $post_mime_types;

}
add_filter( 'post_mime_types', 'jigo_ce_add_post_mime_type' );

function jigo_ce_current_memory_usage() {

	$output = '';
	if( function_exists( 'memory_get_usage' ) )
		$output = round( memory_get_usage( true ) / 1024 / 1024, 2 );
	return $output;

}

function jigo_ce_error_log( $message = '' ) {

	if( $message == '' )
		return;

	error_log( sprintf( '[store-exporter] %s', $message ) );

}

function jigo_ce_error_get_last_message() {

	$output = '-';
	if( function_exists( 'error_get_last' ) ) {
		$last_error = error_get_last();
		if( isset( $last_error ) && isset( $last_error['message'] ) ) {
			$output = $last_error['message'];
		}
		unset( $last_error );
	}
	return $output;

}

function jigo_ce_get_option( $option = null, $default = false, $allow_empty = false ) {

	$output = false;
	if( $option !== null ) {
		$separator = '_';
		$output = get_option( JIGO_CE_PREFIX . $separator . $option, $default );
		if( $allow_empty == false && $output != 0 && ( $output == false || $output == '' ) )
			$output = $default;
	}
	return $output;

}

function jigo_ce_update_option( $option = null, $value = null ) {

	$output = false;
	if( $option !== null && $value !== null ) {
		$separator = '_';
		$output = update_option( JIGO_CE_PREFIX . $separator . $option, $value );
	}
	return $output;

}
?>
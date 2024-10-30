<?php
// Display admin notice on screen load
function jigo_ce_admin_notice( $message = '', $priority = 'updated', $screen = '' ) {

	if( $priority == false || $priority == '' )
		$priority = 'updated';
	if( $message <> '' ) {
		ob_start();
		jigo_ce_admin_notice_html( $message, $priority, $screen );
		$output = ob_get_contents();
		ob_end_clean();
		// Check if an existing notice is already in queue
		$existing_notice = get_transient( JIGO_CE_PREFIX . '_notice' );
		if( $existing_notice !== false ) {
			$existing_notice = base64_decode( $existing_notice );
			$output = $existing_notice . $output;
		}
		set_transient( JIGO_CE_PREFIX . '_notice', base64_encode( $output ), MINUTE_IN_SECONDS );
		add_action( 'admin_notices', 'jigo_ce_admin_notice_print' );
	}

}

// HTML template for admin notice
function jigo_ce_admin_notice_html( $message = '', $priority = 'updated', $screen = '' ) {

	// Display admin notice on specific screen
	if( !empty( $screen ) ) {

		global $pagenow;

		if( is_array( $screen ) ) {
			if( in_array( $pagenow, $screen ) == false )
				return;
		} else {
			if( $pagenow <> $screen )
				return;
		}

	} ?>
<div id="message" class="<?php echo $priority; ?>">
	<p><?php echo $message; ?></p>
</div>
<?php

}

// Grabs the WordPress transient that holds the admin notice and prints it
function jigo_ce_admin_notice_print() {

	$output = get_transient( JIGO_CE_PREFIX . '_notice' );
	if( $output !== false ) {
		delete_transient( JIGO_CE_PREFIX . '_notice' );
		$output = base64_decode( $output );
		echo $output;
	}

}

// HTML template header on Store Exporter screen
function jigo_ce_template_header( $title = '', $icon = 'jigoshop' ) {

	if( $title )
		$output = $title;
	else
		$output = __( 'Store Export', 'jigo_ce' ); ?>
<div class="wrap">
	<div id="icon-<?php echo $icon; ?>" class="icon32 icon32-jigoshop-settings"><br /></div>
	<h2>
		<?php echo $output; ?>
		<a href="<?php echo add_query_arg( array( 'tab' => 'export', 'empty' => null ) ); ?>" class="add-new-h2"><?php _e( 'Add New', 'jigo_ce' ); ?></a>
	</h2>
<?php

}

// HTML template footer on Store Exporter screen
function jigo_ce_template_footer() { ?>
</div>
<!-- .wrap -->
<?php

}

// Add Export and Docs links to the Plugins screen
function jigo_ce_add_settings_link( $links, $file ) {

	// Manually force slug
	$this_plugin = JIGO_CE_RELPATH;

	if( $file == $this_plugin ) {
		$docs_url = 'http://www.visser.com.au/docs/';
		$docs_link = sprintf( '<a href="%s" target="_blank">' . __( 'Docs', 'jigo_ce' ) . '</a>', $docs_url );
		$export_link = sprintf( '<a href="%s">' . __( 'Export', 'jigo_ce' ) . '</a>', add_query_arg( 'page', 'jigo_ce', 'admin.php' ) );
		array_unshift( $links, $docs_link );
		array_unshift( $links, $export_link );
	}
	return $links;

}
add_filter( 'plugin_action_links', 'jigo_ce_add_settings_link', 10, 2 );

// Add Store Export to WordPress Administration menu
function jigo_ce_admin_menu() {

	$page = add_submenu_page( 'jigoshop', __( 'Store Exporter', 'jigo_ce' ), __( 'Store Export', 'jigo_ce' ), 'export', 'jigo_ce', 'jigo_ce_html_page' );
	add_action( 'admin_print_styles-' . $page, 'jigo_ce_enqueue_scripts' );

}
add_action( 'admin_menu', 'jigo_ce_admin_menu', 11 );

// Load CSS and jQuery scripts for Store Exporter screen
function jigo_ce_enqueue_scripts( $hook ) {

	// Date Picker
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'jquery-ui-datepicker', plugins_url( '/templates/admin/jquery-ui-datepicker.css', JIGO_CE_RELPATH ) );

	// Chosen
	wp_enqueue_style( 'jquery-chosen', plugins_url( '/templates/admin/chosen.css', JIGO_CE_RELPATH ) );
	wp_enqueue_script( 'jquery-chosen', plugins_url( '/js/jquery.chosen.js', JIGO_CE_RELPATH ), array( 'jquery' ) );

	// Common
	wp_enqueue_style( 'jigo_ce_styles', plugins_url( '/templates/admin/export.css', JIGO_CE_RELPATH ), 'jigoshop_admin_styles' );
	wp_enqueue_script( 'jigo_ce_scripts', plugins_url( '/templates/admin/export.js', JIGO_CE_RELPATH ), array( 'jquery' ) );
	wp_enqueue_style( 'dashicons' );

	if( JIGO_CE_DEBUG ) {
		wp_enqueue_style( 'jquery-csvToTable', plugins_url( '/templates/admin/jquery-csvtable.css', JIGO_CE_RELPATH ) );
		wp_enqueue_script( 'jquery-csvToTable', plugins_url( '/js/jquery.csvToTable.js', JIGO_CE_RELPATH ), array( 'jquery' ) );
	}

}

// HTML active class for the currently selected tab on the Store Exporter screen
function jigo_ce_admin_active_tab( $tab_name = null, $tab = null ) {

	if( isset( $_GET['tab'] ) && !$tab )
		$tab = $_GET['tab'];
	else if( !isset( $_GET['tab'] ) && jigo_ce_get_option( 'skip_overview', false ) )
		$tab = 'export';
	else
		$tab = 'overview';

	$output = '';
	if( isset( $tab_name ) && $tab_name ) {
		if( $tab_name == $tab )
			$output = ' nav-tab-active';
	}
	echo $output;

}

// HTML template for each tab on the Store Exporter screen
function jigo_ce_tab_template( $tab = '' ) {

	if( !$tab )
		$tab = 'overview';

	// Store Exporter Deluxe
	$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
	$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

	$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/';

	switch( $tab ) {

		case 'overview':
			$skip_overview = jigo_ce_get_option( 'skip_overview', false );
			break;

		case 'export':
			$export_type = sanitize_text_field( ( isset( $_POST['dataset'] ) ? $_POST['dataset'] : jigo_ce_get_option( 'last_export', 'product' ) ) );

			$products = jigo_ce_return_count( 'product' );
			$categories = jigo_ce_return_count( 'category' );
			$tags = jigo_ce_return_count( 'tag' );
			$orders = jigo_ce_return_count( 'order' );
			$customers = jigo_ce_return_count( 'customer' );
			$users = jigo_ce_return_count( 'user' );
			$coupons = jigo_ce_return_count( 'coupon' );

			add_action( 'jigo_ce_export_options', 'jigo_ce_export_options_export_format' );
			if( $product_fields = jigo_ce_get_product_fields() ) {
				foreach( $product_fields as $key => $product_field )
					$product_fields[$key]['disabled'] = ( isset( $product_field['disabled'] ) ? $product_field['disabled'] : 0 );
				add_action( 'jigo_ce_export_product_options_before_table', 'jigo_ce_products_filter_by_product_category' );
				add_action( 'jigo_ce_export_product_options_before_table', 'jigo_ce_products_filter_by_product_tag' );
				add_action( 'jigo_ce_export_product_options_before_table', 'jigo_ce_products_filter_by_product_status' );
				add_action( 'jigo_ce_export_product_options_before_table', 'jigo_ce_products_filter_by_product_type' );
				add_action( 'jigo_ce_export_product_options_after_table', 'jigo_ce_product_sorting' );
				add_action( 'jigo_ce_export_after_form', 'jigo_ce_products_custom_fields' );
			}
			if( $category_fields = jigo_ce_get_category_fields() ) {
				foreach( $category_fields as $key => $category_field )
					$category_fields[$key]['disabled'] = ( isset( $category_field['disabled'] ) ? $category_field['disabled'] : 0 );
				add_action( 'jigo_ce_export_category_options_after_table', 'jigo_ce_category_sorting' );
			}
			if( $tag_fields = jigo_ce_get_tag_fields() ) {
				foreach( $tag_fields as $key => $tag_field )
					$tag_fields[$key]['disabled'] = ( isset( $tag_field['disabled'] ) ? $tag_field['disabled'] : 0 );
				add_action( 'jigo_ce_export_tag_options_after_table', 'jigo_ce_tag_sorting' );
			}
			if( $order_fields = jigo_ce_get_order_fields() ) {
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_date' );
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_status' );
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_customer' );
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_user_role' );
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_product_category' );
				add_action( 'jigo_ce_export_order_options_before_table', 'jigo_ce_orders_filter_by_product_tag' );
				add_action( 'jigo_ce_export_order_options_after_table', 'jigo_ce_order_sorting' );
				add_action( 'jigo_ce_export_options', 'jigo_ce_orders_items_formatting' );
				add_action( 'jigo_ce_export_options', 'jigo_ce_orders_max_order_items' );
				add_action( 'jigo_ce_export_after_form', 'jigo_ce_orders_custom_fields' );
			}
			if( $customer_fields = jigo_ce_get_customer_fields() ) {
				add_action( 'jigo_ce_export_customer_options_before_table', 'jigo_ce_customers_filter_by_status' );
			}
			if( $user_fields = jigo_ce_get_user_fields() ) {
				foreach( $user_fields as $key => $user_field )
					$user_fields[$key]['disabled'] = ( isset( $user_field['disabled'] ) ? $user_field['disabled'] : 0 );
				add_action( 'jigo_ce_export_user_options_after_table', 'jigo_ce_user_sorting' );
			}
			if( $coupon_fields = jigo_ce_get_coupon_fields() ) {
				add_action( 'jigo_ce_export_coupon_options_before_table', 'jigo_ce_coupon_sorting' );
			}

			// Export modules
			$modules = jigo_ce_modules_list();

			// Export options
			$upsell_formatting = jigo_ce_get_option( 'upsell_formatting', 1 );
			$crosssell_formatting = jigo_ce_get_option( 'crosssell_formatting', 1 );
			$limit_volume = jigo_ce_get_option( 'limit_volume' );
			$offset = jigo_ce_get_option( 'offset' );
			break;

		case 'archive':
			if( isset( $_GET['deleted'] ) ) {
				$message = __( 'Archived export has been deleted.', 'jigo_ce' );
				jigo_ce_admin_notice( $message );
			}
			if( $files = jigo_ce_get_archive_files() ) {
				foreach( $files as $key => $file )
					$files[$key] = jigo_ce_get_archive_file( $file );
			}
			break;

		case 'settings':
			$export_filename = jigo_ce_get_option( 'export_filename', '' );
			// Default export filename
			if( empty( $export_filename ) )
				$export_filename = 'jigo-export_%dataset%-%date%.csv';
			$delete_file = jigo_ce_get_option( 'delete_file', 1 );
			$timeout = jigo_ce_get_option( 'timeout', 0 );
			$encoding = jigo_ce_get_option( 'encoding', 'UTF-8' );
			$bom = jigo_ce_get_option( 'bom', 1 );
			$delimiter = jigo_ce_get_option( 'delimiter', ',' );
			$category_separator = jigo_ce_get_option( 'category_separator', '|' );
			$escape_formatting = jigo_ce_get_option( 'escape_formatting', 'all' );
			$date_format = jigo_ce_get_option( 'date_format', 'd/m/Y' );
			$file_encodings = ( function_exists( 'mb_list_encodings' ) ? mb_list_encodings() : false );
			add_action( 'jigo_ce_export_settings_top', 'jigo_ce_export_settings_quicklinks' );
			add_action( 'jigo_ce_export_settings_general', 'jigo_ce_export_settings_additional' );
			add_action( 'jigo_ce_export_settings_after', 'jigo_ce_export_settings_cron' );
			break;

		case 'tools':
			// Product Importer Deluxe
			$jigo_pd_url = 'http://www.visser.com.au/jigoshop/plugins/product-importer-deluxe/';
			$jigo_pd_target = ' target="_blank"';
			if( function_exists( 'jigo_pd_init' ) ) {
				$jigo_pd_url = add_query_arg( 'page', 'jigo_pd' );
				$jigo_pd_target = false;
			}
			break;

	}
	if( $tab ) {
		if( file_exists( JIGO_CE_PATH . 'templates/admin/tabs-' . $tab . '.php' ) ) {
			include_once( JIGO_CE_PATH . 'templates/admin/tabs-' . $tab . '.php' );
		} else {
			$message = sprintf( __( 'We couldn\'t load the export template file <code>%s</code> within <code>%s</code>, this file should be present.', 'jigo_ce' ), 'tabs-' . $tab . '.php', JIGO_CE_PATH . 'templates/admin/...' );
			jigo_ce_admin_notice_html( $message, 'error' );
			ob_start(); ?>
<p><?php _e( 'You can see this error for one of a few common reasons', 'jigo_ce' ); ?>:</p>
<ul class="ul-disc">
	<li><?php _e( 'WordPress was unable to create this file when the Plugin was installed or updated', 'jigo_ce' ); ?></li>
	<li><?php _e( 'The Plugin files have been recently changed and there has been a file conflict', 'jigo_ce' ); ?></li>
	<li><?php _e( 'The Plugin file has been locked and cannot be opened by WordPress', 'jigo_ce' ); ?></li>
</ul>
<p><?php _e( 'Jump onto our website and download a fresh copy of this Plugin as it might be enough to fix this issue. If this persists get in touch with us.', 'jigo_ce' ); ?></p>
<?php
			ob_end_flush();
		}
	}

}

// List of WordPress Plugins that Product Importer Deluxe integrates with
function jigo_ce_modules_list( $modules = array() ) {

	$modules[] = array(
		'name' => 'aioseop',
		'title' => __( 'All in One SEO Pack', 'jigo_ce' ),
		'description' => __( 'Optimize your Jigoshop Products for Search Engines. Requires Store Toolkit for All in One SEO Pack integration.', 'jigo_ce' ),
		'url' => 'http://wordpress.org/extend/plugins/all-in-one-seo-pack/',
		'slug' => 'all-in-one-seo-pack',
		'function' => 'aioseop_activate'
	);
	$modules[] = array(
		'name' => 'store_toolkit',
		'title' => __( 'Store Toolkit', 'jigo_ce' ),
		'description' => __( 'Store Toolkit includes a growing set of commonly-used Jigoshop administration tools aimed at web developers and store maintainers.', 'jigo_ce' ),
		'url' => 'http://wordpress.org/extend/plugins/jigoshop-store-toolkit/',
		'slug' => 'jigoshop-store-toolkit',
		'function' => 'jigo_st_admin_init'
	);
	$modules[] = array(
		'name' => 'ultimate_seo',
		'title' => __( 'SEO Ultimate', 'jigo_ce' ),
		'description' => __( 'This all-in-one SEO plugin gives you control over Product details.', 'jigo_ce' ),
		'url' => 'http://wordpress.org/extend/plugins/seo-ultimate/',
		'slug' => 'seo-ultimate',
		'function' => 'su_wp_incompat_notice'
	);
	$modules[] = array(
		'name' => 'gpf',
		'title' => __( 'Advanced Google Product Feed', 'jigo_ce' ),
		'description' => __( 'Easily configure data to be added to your Google Merchant Centre feed.', 'jigo_ce' ),
		'url' => 'http://www.leewillis.co.uk/wordpress-plugins/',
		'function' => 'jigoshop_gpf_install'
	);
	$modules[] = array(
		'name' => 'wpseo',
		'title' => __( 'WordPress SEO by Yoast', 'jigo_ce' ),
		'description' => __( 'The first true all-in-one SEO solution for WordPress.', 'jigo_ce' ),
		'url' => 'http://yoast.com/wordpress/seo/#utm_source=wpadmin&utm_medium=plugin&utm_campaign=wpseoplugin',
		'slug' => 'wordpress-seo',
		'function' => 'wpseo_admin_init'
	);
	$modules[] = array(
		'name' => 'per_product_shipping',
		'title' => __( 'Per Product Shipping', 'jigo_ce' ),
		'description' => __( 'You can set costs for shipping on a product basis, with minimum and maximum quantities.', 'jigo_ce' ),
		'url' => 'http://www.jigoshop.com/product/per-product-shipping/',
		'slug' => 'per-product-shipping',
		'function' => 'jigoshop_per_product_init'
	);

/*
	$modules[] = array(
		'name' => '',
		'title' => __( '', 'jigo_ce' ),
		'description' => __( '', 'jigo_ce' ),
		'url' => '',
		'slug' => '', // Define this if the Plugin is hosted on the WordPress repo
		'function' => ''
	);
*/

	$modules = apply_filters( 'jigo_ce_modules_addons', $modules );

	if( !empty( $modules ) ) {
		foreach( $modules as $key => $module ) {
			$modules[$key]['status'] = 'inactive';
			// Check if each module is activated
			if( isset( $module['function'] ) ) {
				if( function_exists( $module['function'] ) )
					$modules[$key]['status'] = 'active';
			} else if( isset( $module['class'] ) ) {
				if( class_exists( $module['class'] ) )
					$modules[$key]['status'] = 'active';
			}
			// Check if the Plugin has a slug and if current user can install Plugins
			if( current_user_can( 'install_plugins' ) && isset( $module['slug'] ) )
				$modules[$key]['url'] = admin_url( sprintf( 'plugin-install.php?tab=search&type=tag&s=%s', $module['slug'] ) );
		}
	}
	return $modules;

}

function jigo_ce_modules_status_class( $status = 'inactive' ) {

	$output = '';
	switch( $status ) {

		case 'active':
			$output = 'green';
			break;

		case 'inactive':
			$output = 'yellow';
			break;

	}
	echo $output;

}

function jigo_ce_modules_status_label( $status = 'inactive' ) {

	$output = '';
	switch( $status ) {

		case 'active':
			$output = __( 'OK', 'jigo_ce' );
			break;

		case 'inactive':
			$output = __( 'Install', 'jigo_ce' );
			break;

	}
	echo $output;

}

// HTML template for header prompt on Store Exporter screen
function jigo_ce_support_donate() {

	$output = '';
	$show = true;
	if( function_exists( 'jigo_vl_we_love_your_plugins' ) ) {
		if( in_array( JIGO_CE_DIRNAME, jigo_vl_we_love_your_plugins() ) )
			$show = false;
	}
	if( $show ) {
		$donate_url = 'http://www.visser.com.au/#donations';
		$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . JIGO_CE_DIRNAME;
		$output = '
<div id="support-donate_rate" class="support-donate_rate">
	<p>' . sprintf( __( '<strong>Like this Plugin?</strong> %s and %s.', 'jigo_ce' ), '<a href="' . $donate_url . '" target="_blank">' . __( 'Donate to support this Plugin', 'jigo_ce' ) . '</a>', '<a href="' . add_query_arg( array( 'rate' => '5' ), $rate_url ) . '#postform" target="_blank">rate / review us on WordPress.org</a>' ) . '</p>
</div>
';
	}
	echo $output;

}
?>
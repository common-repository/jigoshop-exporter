<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	// HTML template for Filter Products by Product Category widget on Store Exporter screen
	function jigo_ce_products_filter_by_product_category() {

		$args = array(
			'hide_empty' => 1
		);
		$product_categories = jigo_ce_get_product_categories( $args );

		ob_start(); ?>
<p><label><input type="checkbox" id="products-filters-categories" /> <?php _e( 'Filter Products by Product Categories', 'jigo_ce' ); ?></label></p>
<div id="export-products-filters-categories" class="separator">
<?php if( !empty( $product_categories ) ) { ?>
	<ul>
	<?php foreach( $product_categories as $product_category ) { ?>
		<li>
			<label><input type="checkbox" name="product_filter_category[<?php echo $product_category->term_id; ?>]" value="<?php echo $product_category->term_id; ?>" title="<?php printf( __( 'Term ID: %d', 'jigo_ce' ), $product_category->term_id ); ?>"<?php disabled( $product_category->count, 0 ); ?> /> <?php echo jigo_ce_format_product_category_label( $product_category->name, $product_category->parent_name ); ?></label>
			<span class="description">(<?php echo $product_category->count; ?>)</span>
		</li>
	<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Categories you want to filter exported Products by. Default is to include all Product Categories.', 'jigo_ce' ); ?></p>
<?php } else { ?>
	<p><?php _e( 'No Product Categories have been found.', 'jigo_ce' ); ?></p>
<?php } ?>
</div>
<!-- #export-products-filters-categories -->
<?php
		ob_end_flush();

	}

	// HTML template for Filter Products by Product Tag widget on Store Exporter screen
	function jigo_ce_products_filter_by_product_tag() {

		$args = array(
			'hide_empty' => 1
		);
		$product_tags = jigo_ce_get_product_tags( $args );

		ob_start(); ?>
<p><label><input type="checkbox" id="products-filters-tags" /> <?php _e( 'Filter Products by Product Tags', 'jigo_ce' ); ?></label></p>
<div id="export-products-filters-tags" class="separator">
<?php if( $product_tags ) { ?>
	<ul>
	<?php foreach( $product_tags as $product_tag ) { ?>
		<li>
			<label><input type="checkbox" name="product_filter_tag[<?php echo $product_tag->term_id; ?>]" value="<?php echo $product_tag->term_id; ?>" title="<?php printf( __( 'Term ID: %d', 'jigo_ce' ), $product_tag->term_id ); ?>"<?php disabled( $product_tag->count, 0 ); ?> /> <?php echo $product_tag->name; ?></label>
			<span class="description">(<?php echo $product_tag->count; ?>)</span>
		</li>
	<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Tags you want to filter exported Products by. Default is to include all Product Tags.', 'jigo_ce' ); ?></p>
<?php } else { ?>
	<p><?php _e( 'No Product Tags have been found.', 'jigo_ce' ); ?></p>
<?php } ?>
</div>
<!-- #export-products-filters-tags -->
<?php
		ob_end_flush();

	}

	// HTML template for Filter Products by Product Status widget on Store Exporter screen
	function jigo_ce_products_filter_by_product_status() {

		$product_statuses = get_post_statuses();
		if( !isset( $product_statuses['trash'] ) )
			$product_statuses['trash'] = __( 'Trash', 'jigo_ce' );

		ob_start(); ?>
<p><label><input type="checkbox" id="products-filters-status" /> <?php _e( 'Filter Products by Product Status', 'jigo_ce' ); ?></label></p>
<div id="export-products-filters-status" class="separator">
	<ul>
<?php foreach( $product_statuses as $key => $product_status ) { ?>
		<li><label><input type="checkbox" name="product_filter_status[<?php echo $key; ?>]" value="<?php echo $key; ?>" /> <?php echo $product_status; ?></label></li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Status options you want to filter exported Products by. Default is to include all Product Status options.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-products-filters-status -->
<?php
		ob_end_flush();

	}

	// HTML template for Filter Products by Product Type widget on Store Exporter screen
	function jigo_ce_products_filter_by_product_type() {

		$product_types = jigo_ce_get_product_types();

		ob_start(); ?>
<p><label><input type="checkbox" id="products-filters-type" /> <?php _e( 'Filter Products by Product Type', 'jigo_ce' ); ?></label></p>
<div id="export-products-filters-type" class="separator">
	<ul>
<?php if( $product_types ) { ?>
	<?php foreach( $product_types as $key => $product_type ) { ?>
		<li><label><input type="checkbox" name="product_filter_type[]" value="<?php echo $key; ?>" /> <?php echo jigo_ce_format_product_type( $product_type ); ?></label></li>
	<?php } ?>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Type\'s you want to filter exported Products by. Default is to include all Product Types and Variations.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-products-filters-type -->
<?php
		ob_end_flush();

	}

	// HTML template for Product Sorting widget on Store Exporter screen
	function jigo_ce_product_sorting() {

		$product_orderby = jigo_ce_get_option( 'product_orderby', 'ID' );
		$product_order = jigo_ce_get_option( 'product_order', 'DESC' );

		ob_start(); ?>
<p><label><?php _e( 'Product Sorting', 'jigo_ce' ); ?></label></p>
<div>
	<select name="product_orderby">
		<option value="ID"<?php selected( 'ID', $product_orderby ); ?>><?php _e( 'Product ID', 'jigo_ce' ); ?></option>
		<option value="title"<?php selected( 'title', $product_orderby ); ?>><?php _e( 'Product Name', 'jigo_ce' ); ?></option>
		<option value="date"<?php selected( 'date', $product_orderby ); ?>><?php _e( 'Date Created', 'jigo_ce' ); ?></option>
		<option value="modified"<?php selected( 'modified', $product_orderby ); ?>><?php _e( 'Date Modified', 'jigo_ce' ); ?></option>
		<option value="rand"<?php selected( 'rand', $product_orderby ); ?>><?php _e( 'Random', 'jigo_ce' ); ?></option>
		<option value="menu_order"<?php selected( 'menu_order', $product_orderby ); ?>><?php _e( 'Menu Order', 'jigo_ce' ); ?></option>
	</select>
	<select name="product_order">
		<option value="ASC"<?php selected( 'ASC', $product_order ); ?>><?php _e( 'Ascending', 'jigo_ce' ); ?></option>
		<option value="DESC"<?php selected( 'DESC', $product_order ); ?>><?php _e( 'Descending', 'jigo_ce' ); ?></option>
	</select>
	<p class="description"><?php _e( 'Select the sorting of Products within the exported file. By default this is set to export Products by Product ID in Desending order.', 'jigo_ce' ); ?></p>
</div>
<?php
		ob_end_flush();

	}

	// HTML template for Custom Products widget on Store Exporter screen
	function jigo_ce_products_custom_fields() {

		if( $custom_products = jigo_ce_get_option( 'custom_products', '' ) )
			$custom_products = implode( "\n", $custom_products );

		$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

		ob_start(); ?>
<form method="post" id="export-products-custom-fields" class="export-options product-options">
	<div id="poststuff">

		<div class="postbox" id="export-options product-options">
			<h3 class="hndle"><?php _e( 'Custom Product Fields', 'jigo_ce' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'To include additional custom Product meta in the Export Products table above fill the Products text box then click Save Custom Fields.', 'jigo_ce' ); ?></p>
				<table class="form-table">

					<tr>
						<th>
							<label><?php _e( 'Product meta', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<textarea name="custom_products" rows="5" cols="70"><?php echo esc_textarea( $custom_products ); ?></textarea>
							<p class="description"><?php _e( 'Include additional custom Product meta in your export file by adding each custom Product meta name to a new line above.<br />For example: <code>Customer UA, Customer IP Address</code>', 'jigo_ce' ); ?></p>
						</td>
					</tr>

				</table>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Save Custom Fields', 'jigo_ce' ); ?>" class="button-primary" />
				</p>
				<p class="description"><?php printf( __( 'For more information on custom Product meta consult our <a href="%s" target="_blank">online documentation</a>.', 'jigo_ce' ), $troubleshooting_url ); ?></p>
			</div>
			<!-- .inside -->
		</div>
		<!-- .postbox -->

	</div>
	<!-- #poststuff -->
	<input type="hidden" name="action" value="update" />
</form>
<!-- #export-products-custom-fields -->
<?php
		ob_end_flush();

	}

	/* End of: WordPress Administration */

}

// Returns a list of Jigoshop Product IDs to export process
function jigo_ce_get_products( $args = array() ) {

	$limit_volume = -1;
	$offset = 0;
	$product_categories = false;
	$product_tags = false;
	$product_status = false;
	$product_type = false;
	$orderby = 'ID';
	$order = 'ASC';
	if( $args ) {
		$limit_volume = ( isset( $args['limit_volume'] ) ? $args['limit_volume'] : false );
		$offset = ( isset( $args['offset'] ) ? $args['offset'] : false );
		if( !empty( $args['product_categories'] ) )
			$product_categories = $args['product_categories'];
		if( !empty( $args['product_tags'] ) )
			$product_tags = $args['product_tags'];
		if( !empty( $args['product_status'] ) )
			$product_status = $args['product_status'];
		if( !empty( $args['product_type'] ) )
			$product_type = $args['product_type'];
		if( isset( $args['product_orderby'] ) )
			$orderby = $args['product_orderby'];
		if( isset( $args['product_order'] ) )
			$order = $args['product_order'];
	}
	$post_type = array( 'product', 'product_variation' );
	$args = array(
		'post_type' => $post_type,
		'orderby' => $orderby,
		'order' => $order,
		'offset' => $offset,
		'posts_per_page' => $limit_volume,
		'post_status' => jigo_ce_post_statuses(),
		'fields' => 'ids'
	);
	$args['tax_query'] = array();
	// Filter Products by Product Category
	if( $product_categories ) {
		$term_taxonomy = 'product_cat';
		$args['tax_query'][] = array(
			array(
				'taxonomy' => $term_taxonomy,
				'field' => 'id',
				'terms' => $product_categories
			)
		);
	}
	// Filter Products by Product Tag
	if( $product_tags ) {
		$term_taxonomy = 'product_tag';
		$args['tax_query'][] = array(
			array(
				'taxonomy' => $term_taxonomy,
				'field' => 'id',
				'terms' => $product_tags
			)
		);
	}
	if( $product_status )
		$args['post_status'] = jigo_ce_post_statuses( $product_status, true );
	if( $product_type ) {
		if( in_array( 'variation', $product_type ) && count( $product_type ) == 1 )
			$args['post_type'] = array( 'product_variation' );
		if( !empty( $product_type ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_type',
					'field' => 'slug',
					'terms' => $product_type
				)
			);
		} else {
			unset( $args['meta_query'] );
		}
	}
	$products = array();
	$product_ids = new WP_Query( $args );
	if( $product_ids->posts ) {
		foreach( $product_ids->posts as $product_id ) {
			if( isset( $product_id ) )
				$products[] = $product_id;
		}
		unset( $product_ids, $product_id );
	}
	return $products;

}

function jigo_ce_get_product_data( $product_id = 0, $args = array() ) {

	// Get Product defaults
	$weight_unit = get_option( 'jigoshop_weight_unit' );
	$dimension_unit = get_option( 'jigoshop_dimension_unit' );
	$height_unit = $dimension_unit;
	$width_unit = $dimension_unit;
	$length_unit = $dimension_unit;

	$product = get_post( $product_id );
	$product_data = get_post_meta( $product_id, 'product_metadata', true );

	$product->product_id = $product->ID;
	$product->sku = get_post_meta( $product->ID, 'sku', true );
	if( empty( $product->sku ) )
		$product->sku = $product->ID;
	$product->name = get_the_title( $product->ID );
	$product->permalink = get_permalink( $product->ID );
	$product->slug = $product->post_name;
	$product->description = $product->post_content;
	$product->excerpt = $product->post_excerpt;
	$product->regular_price = jigo_ce_currency_price( get_post_meta( $product->ID, 'regular_price', true ) );
	$product->price = get_post_meta( $product->ID, 'price', true );
	$product->sale_price = jigo_ce_currency_price( get_post_meta( $product->ID, 'sale_price', true ) );
	$product->sale_price_dates_from = jigo_ce_format_sale_price_dates( get_post_meta( $product->ID, '_sale_price_dates_from', true ) );
	$product->sale_price_dates_to = jigo_ce_format_sale_price_dates( get_post_meta( $product->ID, '_sale_price_dates_to', true ) );
	$product->post_date = jigo_ce_format_date( $product->post_date );
	$product->post_modified = jigo_ce_format_date( $product->post_modified );
	$product->type = jigo_ce_get_product_assoc_type( $product->ID );
	$product->visibility = jigo_ce_format_product_visibility( get_post_meta( $product->ID, 'visibility', true ) );
	$product->featured = jigo_ce_format_switch( get_post_meta( $product->ID, 'featured', true ) );
	$product->virtual = jigo_ce_format_switch( get_post_meta( $product->ID, 'virtual', true ) );
	$product->weight = get_post_meta( $product->ID, 'weight', true );
	$product->weight_unit = ( $product->weight != '' ? $weight_unit : '' );
	$product->height = get_post_meta( $product->ID, 'height', true );
	$product->height_unit = ( $product->height != '' ? $height_unit : '' );
	$product->width = get_post_meta( $product->ID, 'width', true );
	$product->width_unit = ( $product->width != '' ? $width_unit : '' );
	$product->length = get_post_meta( $product->ID, 'length', true );
	$product->length_unit = ( $product->length != '' ? $length_unit : '' );
	$product->category = jigo_ce_get_product_assoc_categories( $product->ID );
	$product->tag = jigo_ce_get_product_assoc_tags( $product->ID );
	$product->manage_stock = jigo_ce_format_switch( get_post_meta( $product->ID, 'manage_stock', true ) );
	$product->allow_backorders = jigo_ce_format_allow_backorders( get_post_meta( $product->ID, 'backorders', true ) );
	$product->upsell_ids = jigo_ce_get_product_assoc_upsell_ids( $product->ID );
	$product->crosssell_ids = jigo_ce_get_product_assoc_crosssell_ids( $product->ID );
	$product->quantity = get_post_meta( $product->ID, 'stock', true );
	$product->stock_status = jigo_ce_format_stock_status( get_post_meta( $product->ID, 'stock_status', true ) );
	$product->image = jigo_ce_get_product_assoc_images( $product->ID );
	$product->tax_status = jigo_ce_format_tax_status( get_post_meta( $product->ID, 'tax_status', true ) );
	$product->tax_class = jigo_ce_format_tax_classes( get_post_meta( $product->ID, 'tax_classes', true ) );
	$product->product_url = get_post_meta( $product->ID, 'product_url', true );
	$product->file_download = get_post_meta( $product->ID, 'file_path', true );
	$product->download_limit = get_post_meta( $product->ID, 'download_limit', true );
	$product->product_status = jigo_ce_format_product_status( $product->post_status );
	$product->comment_status = jigo_ce_format_comment_status( $product->comment_status );
	$product->sort_order = $product->menu_order;

	// Advanced Google Product Feed - http://plugins.leewillis.co.uk/downloads/wp-e-commerce-product-feeds/
	if( function_exists( 'jigoshop_gpf_install' ) ) {
		$product->gpf_data = get_post_meta( $product->ID, '_wpec_gpf_data', true );
		$product->gpf_availability = ( isset( $product->gpf_data['availability'] ) ? jigo_ce_format_gpf_availability( $product->gpf_data['availability'] ) : '' );
		$product->gpf_condition = ( isset( $product->gpf_data['condition'] ) ? jigo_ce_format_gpf_condition( $product->gpf_data['condition'] ) : '' );
		$product->gpf_brand = ( isset( $product->gpf_data['brand'] ) ? $product->gpf_data['brand'] : '' );
		$product->gpf_product_type = ( isset( $product->gpf_data['product_type'] ) ? $product->gpf_data['product_type'] : '' );
		$product->gpf_google_product_category = ( isset( $product->gpf_data['google_product_category'] ) ? $product->gpf_data['google_product_category'] : '' );
		$product->gpf_gtin = ( isset( $product->gpf_data['gtin'] ) ? $product->gpf_data['gtin'] : '' );
		$product->gpf_mpn = ( isset( $product->gpf_data['mpn'] ) ? $product->gpf_data['mpn'] : '' );
		$product->gpf_gender = ( isset( $product->gpf_data['gender'] ) ? $product->gpf_data['gender'] : '' );
		$product->gpf_age_group = ( isset( $product->gpf_data['age_group'] ) ? $product->gpf_data['age_group'] : '' );
		$product->gpf_color = ( isset( $product->gpf_data['color'] ) ? $product->gpf_data['color'] : '' );
		$product->gpf_size = ( isset( $product->gpf_data['size'] ) ? $product->gpf_data['size'] : '' );
	}

	// All in One SEO Pack - http://wordpress.org/extend/plugins/all-in-one-seo-pack/
	if( function_exists( 'aioseop_activate' ) ) {
		$product->aioseop_keywords = get_post_meta( $product->ID, '_aioseop_keywords', true );
		$product->aioseop_description = get_post_meta( $product->ID, '_aioseop_description', true );
		$product->aioseop_title = get_post_meta( $product->ID, '_aioseop_title', true );
		$product->aioseop_titleatr = get_post_meta( $product->ID, '_aioseop_titleatr', true );
		$product->aioseop_menulabel = get_post_meta( $product->ID, '_aioseop_menulabel', true );
	}

	// WordPress SEO - http://wordpress.org/plugins/wordpress-seo/
	if( function_exists( 'wpseo_admin_init' ) ) {
		$product->wpseo_focuskw = get_post_meta( $product->ID, '_yoast_wpseo_focuskw', true );
		$product->wpseo_metadesc = get_post_meta( $product->ID, '_yoast_wpseo_metadesc', true );
		$product->wpseo_title = get_post_meta( $product->ID, '_yoast_wpseo_title', true );
		$product->wpseo_googleplus_description = get_post_meta( $product->ID, '_yoast_wpseo_google-plus-description', true );
		$product->wpseo_opengraph_description = get_post_meta( $product->ID, '_yoast_wpseo_opengraph-description', true );
	}

	// Ultimate SEO - http://wordpress.org/plugins/seo-ultimate/
	if( function_exists( 'su_wp_incompat_notice' ) ) {
		$product->useo_meta_title = get_post_meta( $product->ID, '_su_title', true );
		$product->useo_meta_description = get_post_meta( $product->ID, '_su_description', true );
		$product->useo_meta_keywords = get_post_meta( $product->ID, '_su_keywords', true );
		$product->useo_social_title = get_post_meta( $product->ID, '_su_og_title', true );
		$product->useo_social_description = get_post_meta( $product->ID, '_su_og_description', true );
		$product->useo_meta_noindex = get_post_meta( $product->ID, '_su_meta_robots_noindex', true );
		$product->useo_meta_noautolinks = get_post_meta( $product->ID, '_su_disable_autolinks', true );
	}

	// Per Product Shipping - http://jigoshop.com
	if( function_exists( 'jigoshop_per_product_init' ) ) {
		$product->per_product_shipping = jigo_ce_get_product_assoc_per_product_shipping( $product->ID );
	}

	// Allow Plugin/Theme authors to add support for additional Product columns
	return apply_filters( 'jigo_ce_product_item', $product, $product->ID );

}

// Returns Product Categories associated to a specific Product
function jigo_ce_get_product_assoc_categories( $product_id = 0 ) {

	global $export;

	$output = '';
	$term_taxonomy = 'product_cat';
	if( $product_id )
		$categories = wp_get_object_terms( $product_id, $term_taxonomy );
	if( !empty( $categories ) && !is_wp_error( $categories ) ) {
		$size = count( $categories );
		for( $i = 0; $i < $size; $i++ ) {
			if( $categories[$i]->parent == '0' ) {
				$output .= $categories[$i]->name . $export->category_separator;
			} else {
				// Check if Parent -> Child
				$parent_category = get_term( $categories[$i]->parent, $term_taxonomy );
				// Check if Parent -> Child -> Subchild
				if( $parent_category->parent == '0' ) {
					$output .= $parent_category->name . '>' . $categories[$i]->name . $export->category_separator;
					$output = str_replace( $parent_category->name . $export->category_separator, '', $output );
				} else {
					$root_category = get_term( $parent_category->parent, $term_taxonomy );
					$output .= $root_category->name . '>' . $parent_category->name . '>' . $categories[$i]->name . $export->category_separator;
					$output = str_replace( array(
						$root_category->name . '>' . $parent_category->name . $export->category_separator,
						$parent_category->name . $export->category_separator
					), '', $output );
				}
				unset( $root_category, $parent_category );
			}
		}
		$output = substr( $output, 0, -1 );
	} else {
		$output .= __( 'Uncategorized', 'jigo_ce' );
	}
	return $output;

}

// Returns Product Tags associated to a specific Product
function jigo_ce_get_product_assoc_tags( $product_id = 0 ) {

	global $export;

	$output = '';
	$term_taxonomy = 'product_tag';
	$tags = wp_get_object_terms( $product_id, $term_taxonomy );
	if( !empty( $tags ) && is_wp_error( $tags ) == false ) {
		$size = count( $tags );
		for( $i = 0; $i < $size; $i++ ) {
			if( $tag = get_term( $tags[$i]->term_id, $term_taxonomy ) )
				$output .= $tag->name . $export->category_separator;
		}
		$output = substr( $output, 0, -1 );
	}
	return $output;

}

// Returns the Images associated to a specific Product
function jigo_ce_get_product_assoc_images( $product_id = 0 ) {

	$output = '';
	if( $product_id ) {
		if( $thumbnail_id = get_post_meta( $product_id, '_thumbnail_id', true ) ) {
			if( $thumbnail_post = get_post( $thumbnail_id ) )
				$output = $thumbnail_post->guid;
		}
	}
	return $output;

}

function jigo_ce_get_product_assoc_per_product_shipping( $product_id = 0 ) {

	global $export;

	$output = '';
	if( $per_product_shippings = get_post_meta( $product_id, 'per_product_shipping', true ) ) {
		foreach( $per_product_shippings as $per_product_shipping ) {
			// Check that the Start Qty has been filled and a Shipping Cost entered
			if( $per_product_shipping['shipping_range_begin_qty'] > 0 && isset( $per_product_shipping['shipping_range_price'] ) )
				$output .= sprintf( '%d:%s', $per_product_shipping['shipping_range_begin_qty'], jigo_ce_currency_price( $per_product_shipping['shipping_range_price'] ) ) . $export->category_separator;
		}
		$output = substr( $output, 0, -1 );
	}
	return $output;

}

// Returns the Product Type of a specific Product
function jigo_ce_get_product_assoc_type( $product_id = 0 ) {

	global $export;

	$output = '';
	$term_taxonomy = 'product_type';
	$types = wp_get_object_terms( $product_id, $term_taxonomy );
	if( $types ) {
		$size = count( $types );
		for( $i = 0; $i < $size; $i++ ) {
			$type = get_term( $types[$i]->term_id, $term_taxonomy );
			$output .= jigo_ce_format_product_type( $type->name ) . $export->category_separator;
		}
		$output = substr( $output, 0, -1 );
	}
	return $output;

}

// Returns the Up-Sell associated to a specific Product
function jigo_ce_get_product_assoc_upsell_ids( $product_id = 0 ) {

	global $export;

	$output = '';
	if( $product_id ) {
		$upsell_ids = get_post_meta( $product_id, 'upsell_ids', true );
		// Convert Product ID to Product SKU as per Up-Sells Formatting
		if( $export->upsell_formatting == 1 && !empty( $upsell_ids ) ) {
			$size = count( $upsell_ids );
			for( $i = 0; $i < $size; $i++ ) {
				$upsell_ids[$i] = get_post_meta( $upsell_ids[$i], '_sku', true );
				if( empty( $upsell_ids[$i] ) )
					unset( $upsell_ids[$i] );
			}
			// 'reindex' array
			$upsell_ids = array_values( $upsell_ids );
		}
		$output = jigo_ce_convert_product_ids( $upsell_ids );
	}
	return $output;

}

// Returns the Cross-Sell associated to a specific Product
function jigo_ce_get_product_assoc_crosssell_ids( $product_id = 0 ) {

	global $export;

	$output = '';
	if( $product_id ) {
		$crosssell_ids = get_post_meta( $product_id, 'crosssell_ids', true );
		// Convert Product ID to Product SKU as per Cross-Sells Formatting
		if( $export->crosssell_formatting == 1 && !empty( $crosssell_ids ) ) {
			$size = count( $crosssell_ids );
			for( $i = 0; $i < $size; $i++ ) {
				$crosssell_ids[$i] = get_post_meta( $crosssell_ids[$i], '_sku', true );
				// Remove Cross-Sell if SKU is empty
				if( empty( $crosssell_ids[$i] ) )
					unset( $crosssell_ids[$i] );
			}
			// 'reindex' array
			$crosssell_ids = array_values( $crosssell_ids );
		}
		$output = jigo_ce_convert_product_ids( $crosssell_ids );
	}
	return $output;

}

function jigo_ce_format_product_visibility( $visibility = '' ) {

	$output = '';
	if( $visibility ) {
		switch( $visibility ) {

			case 'visible':
				$output = __( 'Catalog & Search', 'jigo_ce' );
				break;

			case 'catalog':
				$output = __( 'Catalog', 'jigo_ce' );
				break;

			case 'search':
				$output = __( 'Search', 'jigo_ce' );
				break;

			case 'hidden':
				$output = __( 'Hidden', 'jigo_ce' );
				break;

		}
	}
	return $output;

}

// Returns a list of Product export columns
function jigo_ce_get_product_fields( $format = 'full' ) {

	$export_type = 'product';

	$fields = array();
	$fields[] = array(
		'name' => 'parent_id',
		'label' => __( 'Parent ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'parent_sku',
		'label' => __( 'Parent SKU', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'product_id',
		'label' => __( 'Product ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'sku',
		'label' => __( 'Product SKU', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'name',
		'label' => __( 'Product Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'slug',
		'label' => __( 'Slug', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'permalink',
		'label' => __( 'Permalink', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'description',
		'label' => __( 'Description', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'excerpt',
		'label' => __( 'Excerpt', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'post_date',
		'label' => __( 'Product Published', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'post_modified',
		'label' => __( 'Product Modified', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'type',
		'label' => __( 'Type', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'visibility',
		'label' => __( 'Visibility', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'featured',
		'label' => __( 'Featured', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'regular_price',
		'label' => __( 'Regular Price', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'sale_price',
		'label' => __( 'Sale Price', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'sale_price_dates_from',
		'label' => __( 'Sale Price Dates From', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'sale_price_dates_to',
		'label' => __( 'Sale Price Dates To', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'weight',
		'label' => __( 'Weight', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'weight_unit',
		'label' => __( 'Weight Unit', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'height',
		'label' => __( 'Height', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'height_unit',
		'label' => __( 'Height Unit', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'width',
		'label' => __( 'Width', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'width_unit',
		'label' => __( 'Width Unit', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'length',
		'label' => __( 'Length', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'length_unit',
		'label' => __( 'Length Unit', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'category',
		'label' => __( 'Category', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'tag',
		'label' => __( 'Tag', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'image',
		'label' => __( 'Featured Image', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'tax_status',
		'label' => __( 'Tax Status', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'tax_class',
		'label' => __( 'Tax Class', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'file_download',
		'label' => __( 'File Download', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'download_limit',
		'label' => __( 'Download Limit', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'manage_stock',
		'label' => __( 'Manage Stock', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'quantity',
		'label' => __( 'Quantity', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'stock_status',
		'label' => __( 'Stock Status', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'allow_backorders',
		'label' => __( 'Allow Backorders', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'upsell_ids',
		'label' => __( 'Up-Sells', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'crosssell_ids',
		'label' => __( 'Cross-Sells', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'product_url',
		'label' => __( 'Product URL', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'customizable',
		'label' => __( 'Customizable', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'personalized_characters',
		'label' => __( 'Personalized Characters', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'product_group',
		'label' => __( 'Product Group', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'product_status',
		'label' => __( 'Product Status', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'comment_status',
		'label' => __( 'Comment Status', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'sort_order',
		'label' => __( 'Sort Order', 'jigo_ce' )
	);

/*
	$fields[] = array(
		'name' => '',
		'label' => __( '', 'jigo_ce' )
	);
*/

	// Allow Plugin/Theme authors to add support for additional Product columns
	$fields = apply_filters( 'jigo_ce_product_fields', $fields );

	if( $remember = jigo_ce_get_option( 'product_fields', array() ) ) {
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

function jigo_ce_extend_product_fields( $fields ) {

	// Attributes
	if( $attributes = jigo_ce_get_product_attributes() ) {
		foreach( $attributes as $attribute ) {
			$fields[] = array(
				'name' => sprintf( 'attribute_%s', $attribute['name'] ),
				'label' => sprintf( __( 'Attribute: %s', 'jigo_ce' ), ucwords( $attribute['label'] ) )
			);
		}
	}

	// Advanced Google Product Feed - http://www.leewillis.co.uk/wordpress-plugins/
	if( function_exists( 'jigoshop_gpf_install' ) ) {
		$fields[] = array(
			'name' => 'gpf_availability',
			'label' => __( 'Advanced Google Product Feed - Availability', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_condition',
			'label' => __( 'Advanced Google Product Feed - Condition', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_brand',
			'label' => __( 'Advanced Google Product Feed - Brand', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_productype',
			'label' => __( 'Advanced Google Product Feed - Product Type', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_google_product_category',
			'label' => __( 'Advanced Google Product Feed - Google Product Category', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_gtin',
			'label' => __( 'Advanced Google Product Feed - Global Trade Item Number (GTIN)', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_mpn',
			'label' => __( 'Advanced Google Product Feed - Manufacturer Part Number (MPN)', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_gender',
			'label' => __( 'Advanced Google Product Feed - Gender', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_agegroup',
			'label' => __( 'Advanced Google Product Feed - Age Group', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_colour',
			'label' => __( 'Advanced Google Product Feed - Colour', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'gpf_size',
			'label' => __( 'Advanced Google Product Feed - Size', 'jigo_ce' )
		);
	}

	// All in One SEO Pack - http://wordpress.org/extend/plugins/all-in-one-seo-pack/
	if( function_exists( 'aioseop_activate' ) ) {
		$fields[] = array(
			'name' => 'aioseop_keywords',
			'label' => __( 'All in One SEO - Keywords', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'aioseop_description',
			'label' => __( 'All in One SEO - Description', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'aioseop_title',
			'label' => __( 'All in One SEO - Title', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'aioseop_title_attributes',
			'label' => __( 'All in One SEO - Title Attributes', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'aioseop_menu_label',
			'label' => __( 'All in One SEO - Menu Label', 'jigo_ce' )
		);
	}

	// WordPress SEO - http://wordpress.org/plugins/wordpress-seo/
	if( function_exists( 'wpseo_admin_init' ) ) {
		$fields[] = array(
			'name' => 'wpseo_focuskw',
			'label' => __( 'WordPress SEO - Focus Keyword', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'wpseo_metadesc',
			'label' => __( 'WordPress SEO - Meta Description', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'wpseo_title',
			'label' => __( 'WordPress SEO - SEO Title', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'wpseo_googleplus_description',
			'label' => __( 'WordPress SEO - Google+ Description', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'wpseo_opengraph_description',
			'label' => __( 'WordPress SEO - Facebook Description', 'jigo_ce' )
		);
	}

	// Ultimate SEO - http://wordpress.org/plugins/seo-ultimate/
	if( function_exists( 'su_wp_incompat_notice' ) ) {
		$fields[] = array(
			'name' => 'useo_meta_title',
			'label' => __( 'Ultimate SEO - Title Tag', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_meta_description',
			'label' => __( 'Ultimate SEO - Meta Description', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_meta_keywords',
			'label' => __( 'Ultimate SEO - Meta Keywords', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_social_title',
			'label' => __( 'Ultimate SEO - Social Title', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_social_description',
			'label' => __( 'Ultimate SEO - Social Description', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_meta_noindex',
			'label' => __( 'Ultimate SEO - NoIndex', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
		$fields[] = array(
			'name' => 'useo_meta_noautolinks',
			'label' => __( 'Ultimate SEO - Disable Autolinks', 'jigo_ce' ),
			'hover' => __( 'Ultimate SEO', 'jigo_ce' )
		);
	}

	// Per Product Shipping - http://jigoshop.com
	if( function_exists( 'jigoshop_per_product_init' ) ) {
		$fields[] = array(
			'name' => 'per_product_shipping',
			'label' => __( 'Per Product Shipping', 'jigo_ce' )
		);
	}

	// Custom Product meta
	$custom_products = jigo_ce_get_option( 'custom_products', '' );
	if( !empty( $custom_products ) ) {
		foreach( $custom_products as $custom_product ) {
			if( !empty( $custom_product ) ) {
				$fields[] = array(
					'name' => $custom_product,
					'label' => $custom_product
				);
			}
		}
		unset( $custom_products, $custom_product );
	}

	return $fields;

}
add_filter( 'jigo_ce_product_fields', 'jigo_ce_extend_product_fields' );

// Returns the export column header label based on an export column slug
function jigo_ce_get_product_field( $name = null, $format = 'name' ) {

	$output = '';
	if( $name ) {
		$fields = jigo_ce_get_product_fields();
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

// Returns a list of Jigoshop Product Types to export process
function jigo_ce_get_product_types() {

	$term_taxonomy = 'product_type';
	$args = array(
		'hide_empty' => 0
	);
	$types = get_terms( $term_taxonomy, $args );
	if( !empty( $types ) && is_wp_error( $types ) == false ) {
		$output = array();
		$size = count( $types );
		for( $i = 0; $i < $size; $i++ )
			$output[$types[$i]->slug] = $types[$i]->name;
		$output['variation'] = __( 'variation', 'jigo_ce' );
		asort( $output );
		return $output;
	}

}

// Returns a list of Jigoshop Product Categories to export process
function jigo_ce_get_product_attributes() {

	global $wpdb;

	$output = array();
	$attributes_sql = "SELECT `attribute_name` as name, `attribute_label` as label, `attribute_type` as type FROM `" . $wpdb->prefix . "jigoshop_attribute_taxonomies`";
	$attributes = $wpdb->get_results( $attributes_sql );
	$wpdb->flush();
	if( $attributes ) {
		foreach( $attributes as $attribute ) {
			if( !$attribute->label )
				$attribute->label = $attribute->name;
			$output[] = array(
				'label' => $attribute->label,
				'name' => strtolower( $attribute->name ),
				'type' => $attribute->type
			);
		}
	}
	return $output;

}

function jigo_ce_extend_product_item( $product, $product_id ) {

	// Custom Product meta
	$custom_products = jigo_ce_get_option( 'custom_products', '' );
	if( !empty( $custom_products ) ) {
		foreach( $custom_products as $custom_product ) {
			// Check that the custom Product name is filled and it hasn't previously been set
			if( !empty( $custom_product ) && !isset( $product->{$custom_product} ) )
				$product->{$custom_product} = get_post_meta( $product->ID, $custom_product, true );
		}
	}

	return $product;

}
add_filter( 'jigo_ce_product_item', 'jigo_ce_extend_product_item', 10, 2 );

function jigo_ce_format_product_type( $type_id = '' ) {

	$output = $type_id;
	if( $output ) {
		$product_types = apply_filters( 'jigo_ce_format_product_types', array(
			'simple' => __( 'Simple', 'jigoshop' ),
			'configurable' => __( 'Configurable', 'jigoshop' ),
			'downloadable' => __( 'Downloadable', 'jigoshop' ),
			'grouped' => __( 'Grouped', 'jigoshop' ),
			'virtual' => __( 'Virtual', 'jigoshop' ),
			'variable' => __( 'Variable', 'jigoshop' ),
			'external' => __( 'External / Affiliate', 'jigoshop' ),
			'variation' => __( 'Variation', 'jigo_ce' )
		) );
		if( isset( $product_types[$type_id] ) )
			$output = $product_types[$type_id];
	}
	return $output;

}
?>